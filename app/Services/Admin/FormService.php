<?php


namespace App\Services\Admin;


use App\Models\Advantage;
use App\Models\Language;
use App\Services\LanguageHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FormService
{


    public function getFormFields($arFields, $values = null, $prefix = '', $id = '')
    {
        $arFormFields = [];
        foreach ($arFields as $key => $arField) {
            if ($prefix && $id) {
                $name = sprintf('%s[%s][%s]', $prefix, $id, $key);
            } else {
                $name = $key;
            }
            if (is_array($values)) {
                if (isset($values[$key]) && $values[$key]) {
                    $arField['value'] = $values[$key];
                }
            } elseif (is_object($values)) {
                if (isset($values->$key) && $values->$key) {
                    $arField['value'] = $values->$key;
                }
            }


            $arFormFields[] = $this->getField($arField, $name, $key);
        }
        return $arFormFields;
    }

    public function getField($arField, $name, $key)
    {
        switch ($key) {
            case 'name':
                $max = 'maxlength="60"';
                break;
            case 'slug':
                $max = 'maxlength="15"';
                break;
            default:
                $max = 'maxlength="200"';
                break;
        }
        $html = '';
        if (isset($arField['show_if']) && $arField['show_if']) {
            $showIf = sprintf('data-show-if="%s"', $arField['show_if']);
        } else {
            $showIf = '';
        }
        if(!isset($arField['value']))
            $arField['value'] = null;
        if (isset($arField['type']) && $arField['type'])
            switch ($arField['type']) {
                case 'textarea':
                    $html = sprintf('<div class="form-group m-form__group row" %6$s>
											<label for="%3$s" class="col-2 col-form-label">
												%1$s
											</label>
											<div class="col-10">
												<textarea rows="10" class="form-control m-input" name="%2$s" type="text" id="%3$s" %5$s >%4$s</textarea>
											</div>
										</div>', $arField['label'], $name, str_replace(['[', ']'], ['_', ''], $name),
                        $arField['value'] ?? '', $max, $showIf);
                    break;
                case 'date':
                    $type = $arField['input_type'] ?? 'datetime-local';

                    if (isset($arField['multiple']) && $arField['multiple'] == 'Y') {
                        $inputHtml = '';
                        if (isset($arField['value']) && $arField['value'] && is_array($arField['value'])) {
                            foreach ($arField['value'] as $value) {
                                if (is_array($value)) {
                                    $value = reset($value);
                                }
                                if (isset($value) && $value)
                                    switch ($type) {
                                        case 'date':
                                            $value = date('Y-m-d', strtotime($value));
                                            break;
                                        case 'time':
                                            $value = date('H:i', strtotime($value));
                                            break;
                                        default:
                                            $value = date('Y-m-d\TH:i:00',strtotime($value));
                                            break;
                                    }
                                $inputHtml .= sprintf('<div data-repeater-item class="form-group m-form__group row align-items-center">
														<div class="col-md-10">
															<input type="%3$s" name="%1$s" value="%2$s" class="form-control m-input" max="9999-12-31T23:59">
															<div class="d-md-none m--margin-bottom-10"></div>
														</div>
														<div class="col-md-2">
															<div data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">
																<span>
																	<i class="la la-trash-o"></i>
																	<span>
																		Удалить
																	</span>
																</span>
															</div>
														</div>
													</div>', $name, $value ?? '', $type);
                            }
                        }
                        $inputHtml .= sprintf('<div data-repeater-item class="form-group m-form__group row align-items-center">
														<div class="col-md-10">
															<input type="%2$s"  name="%1$s" class="form-control m-input">
															<div class="d-md-none m--margin-bottom-10"></div>
														</div>
														<div class="col-md-2">
															<div data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">
																<span>
																	<i class="la la-trash-o"></i>
																	<span>
																		Удалить
																	</span>
																</span>
															</div>
														</div>
													</div>', $name, $type);

                        $html = sprintf('<div class="repeater_block" %4$s>
											<div class="form-group  m-form__group row" >
												<label  class="col-lg-2 col-form-label">
													%1$s:
												</label>
												<div data-repeater-list="%3$s" class="col-lg-10">
												%2$s
												</div>
											</div>
											<div class="m-form__group form-group row">
												<label class="col-lg-2 col-form-label"></label>
												<div class="col-lg-4">
													<div data-repeater-create="" class="btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
														<span>
															<i class="la la-plus"></i>
															<span>
																Добавить
															</span>
														</span>
													</div>
												</div>
											</div>
										</div>', $arField['label'], $inputHtml, $name, $showIf);
                    } else {
                        if (isset($arField['value']) && $arField['value'])
                            switch ($type) {
                                case 'date':
                                    $arField['value'] = date('Y-m-d', strtotime($arField['value']));
                                    break;
                                case 'time':
                                    $arField['value'] = date('H:i', strtotime($arField['value']));
                                    break;
                                default:
                                    $arField['value'] = date('Y-m-d\TH:i:00',strtotime($arField['value']));
                                    break;
                            }
                        $html = sprintf('<div class="form-group m-form__group row" %6$s>
											<label for="%3$s" class="col-2 col-form-label">
												%1$s
											</label>
											<div class="col-10">
												<input class="form-control m-input" name="%2$s" type="%5$s" value="%4$s" id="%3$s" max="9999-12-31T23:59">
											</div>
										</div>', $arField['label'], $name, str_replace(['[', ']'], ['_', ''], $name),
                            $arField['value'], $type, $showIf);
                    }
                    break;
                case 'text':
                    if (isset($arField['multiple']) && $arField['multiple'] == 'Y') {
                        $inputHtml = '';
                        if (isset($arField['value']) && $arField['value'] && is_array($arField['value'])) {
                            foreach ($arField['value'] as $value) {
                                if (is_array($value)) {
                                    $value = reset($value);
                                }
                                $inputHtml .= sprintf('<div data-repeater-item class="form-group m-form__group row align-items-center">
														<div class="col-md-10">
															<input type="text" name="%1$s" value="%2$s" class="form-control m-input" %3$s>
															<div class="d-md-none m--margin-bottom-10"></div>
														</div>
														<div class="col-md-2">
															<div data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">
																<span>
																	<i class="la la-trash-o"></i>
																	<span>
																		Удалить
																	</span>
																</span>
															</div>
														</div>
													</div>', $name, $value ?? '', $max);
                            }
                        }
                        $inputHtml .= sprintf('<div data-repeater-item class="form-group m-form__group row align-items-center">
														<div class="col-md-10">
															<input type="text"  name="%1$s" class="form-control m-input">
															<div class="d-md-none m--margin-bottom-10"></div>
														</div>
														<div class="col-md-2">
															<div data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">
																<span>
																	<i class="la la-trash-o"></i>
																	<span>
																		Удалить
																	</span>
																</span>
															</div>
														</div>
													</div>', $name);

                        $html = sprintf('<div class="repeater_block" data-max-items="%4$s" %5$s>
											<div class="form-group  m-form__group row" >
												<label  class="col-lg-2 col-form-label">
													%1$s:
												</label>
												<div data-repeater-list="%3$s" class="col-lg-10">
												%2$s
												</div>
											</div>
											<div class="m-form__group form-group row">
												<label class="col-lg-2 col-form-label"></label>
												<div class="col-lg-4">
													<div data-repeater-create="" class="btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
														<span>
															<i class="la la-plus"></i>
															<span>
																Добавить
															</span>
														</span>
													</div>
												</div>
											</div>
										</div>', $arField['label'], $inputHtml, $name, $arField['max_count'] ?? '',
                            $showIf);
                    } else {
                        $html = sprintf('<div class="form-group m-form__group row" %6$s>
											<label for="%3$s" class="col-2 col-form-label">
												%1$s
											</label>
											<div class="col-10">
												<input class="form-control m-input" name="%2$s" type="text" value="%4$s" id="%3$s" %5$s>
											</div>
										</div>', $arField['label'], $name,
                            str_replace(['[', ']'], ['_', ''], $name, $showIf),
                            $arField['value'] ?? '', $max, $showIf);
                    }
                    break;
                case 'editor':
                    if (isset($arField['multiple']) && $arField['multiple'] == 'Y') {
                        $inputHtml = '';
                        if (isset($arField['value']) && $arField['value'] && is_array($arField['value'])) {
                            foreach ($arField['value'] as $value) {
                                if (is_array($value)) {
                                    $value = reset($value);
                                }
                                $inputHtml .= sprintf('<div data-repeater-item class="form-group m-form__group row align-items-center">
														<div class="col-md-10">
															<textarea class="summernote" name="%1$s" %3$s>%2$s</textarea>
															<div class="d-md-none m--margin-bottom-10"></div>
														</div>
														<div class="col-md-2">
															<div data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">
																<span>
																	<i class="la la-trash-o"></i>
																	<span>
																		Удалить
																	</span>
																</span>
															</div>
														</div>
													</div>', $name, $value ?? '', $max);
                            }
                        } else {
                            $inputHtml .= sprintf('<div data-repeater-item class="form-group m-form__group row align-items-center">
														<div class="col-md-10">
															<textarea class="summernote" name="%1$s" %2$s></textarea>
															<div class="d-md-none m--margin-bottom-10"></div>
														</div>
														<div class="col-md-2">
															<div data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">
																<span>
																	<i class="la la-trash-o"></i>
																	<span>
																		Удалить
																	</span>
																</span>
															</div>
														</div>
													</div>', $name, $max);
                        }


                        $html = sprintf('<div class="repeater_block" %4$s>
											<div class="form-group  m-form__group row" >
												<label  class="col-lg-2 col-form-label">
													%s:
												</label>
												<div data-repeater-list="%3$s" class="col-lg-10">
												%s
												</div>
											</div>
											<div class="m-form__group form-group row">
												<label class="col-lg-2 col-form-label"></label>
												<div class="col-lg-4">
													<div data-repeater-create="" class="btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
														<span>
															<i class="la la-plus"></i>
															<span>
																Добавить
															</span>
														</span>
													</div>
												</div>
											</div>
										</div>', $arField['label'], $inputHtml, $name, $showIf);
                    } else {
                        $html = sprintf('<div class="form-group m-form__group row" %5$s>
											<label for="%3$s" class="col-2 col-form-label">
												%1$s
											</label>
											<div class="col-10">
											<textarea class="summernote" name="%2$s" id="%3$s">%4$s</textarea>
											</div>
										</div>', $arField['label'], $name, str_replace(['[', ']'], ['_', ''], $name),
                            $arField['value'] ?? '', $showIf);
                    }
                    break;
                case 'file':
                    if (isset($arField['multiple']) && $arField['multiple'] == 'Y') {
                        $inputHtml = '';
                        if (isset($arField['value']) && $arField['value'] && is_array($arField['value'])) {
                            foreach ($arField['value'] as $value) {
                                if (is_array($value)) {
                                    $value = reset($value);
                                }
                                $arNames = explode('.', $value);
                                $format = end($arNames);
                                $mimeType = explode('/',
                                    Storage::disk('public')->mimeType(str_replace('/storage/', '', $value)));
                                if ($mimeType[0] == 'image') {
                                    $src = asset($value);
                                } else {
                                    if (file_exists(sprintf('%s/admin/assets/app/media/img/files/%s.svg',
                                        $_SERVER['DOCUMENT_ROOT'], $format))) {
                                        $src = asset(sprintf('/admin/assets/app/media/img/files/%s.svg', $format));
                                    } else {
                                        $src = asset('/admin/assets/app/media/img/files/doc.svg');
                                    }
                                }
                                $img = sprintf('<div class="img_block">
<div class="img_item"><a href="%4$s" target="_blank"><img src="%1$s"></a></div>
                <input name="%2$s" type="hidden" value="%3$s" id="%2$s"></div>', $src,
                                    str_replace($key, sprintf('%s_old', $key), $name), $arField['value'] ?? '',
                                    asset($value));

                                $inputHtml .= sprintf('<div data-repeater-item class="form-group m-form__group row align-items-center">
														<div class="col-md-10">
															<div class="custom-file">
                                                            <input class="custom-file-input" name="%1$s" type="file">
                                                            <label class="custom-file-label">Выберите файл</label>
                                                        </div>
															<div class="d-md-none m--margin-bottom-10"></div>
															%2$s
														</div>
														<div class="col-md-2">
															<div data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">
																<span>
																	<i class="la la-trash-o"></i>
																	<span>
																		Удалить
																	</span>
																</span>
															</div>
														</div>
													</div>', $name, $img ?? '');
                            }
                        }
                        $inputHtml .= sprintf('<div data-repeater-item class="form-group m-form__group row align-items-center">
														<div class="col-md-10">
														<div class="custom-file">
                                                            <input class="custom-file-input" name="%1$s" type="file">
                                                            <label class="custom-file-label">Выберите файл</label>
                                                        </div>
															<div class="d-md-none m--margin-bottom-10"></div>
														</div>
														<div class="col-md-2">
															<div data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">
																<span>
																	<i class="la la-trash-o"></i>
																	<span>
																		Удалить
																	</span>
																</span>
															</div>
														</div>
													</div>', $name);

                        $html = sprintf('<div class="repeater_block" %4$s>
											<div class="form-group  m-form__group row" >
												<label  class="col-lg-2 col-form-label">
													%s:
												</label>
												<div data-repeater-list="%3$s" class="col-lg-10">
												%s
												</div>
											</div>
											<div class="m-form__group form-group row">
												<label class="col-lg-2 col-form-label"></label>
												<div class="col-lg-4">
													<div data-repeater-create="" class="btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
														<span>
															<i class="la la-plus"></i>
															<span>
																Добавить
															</span>
														</span>
													</div>
												</div>
											</div>
										</div>', $arField['label'], $inputHtml, $name, $showIf);
                    } else {
                        if (isset($arField['value']) && $arField['value']) {
                            $arNames = explode('.', $arField['value']);
                            $format = end($arNames);
                            $mimeType = explode('/',
                                Storage::disk('public')->mimeType(str_replace('/storage/', '', $arField['value'])));
                            if ($mimeType[0] == 'image') {
                                $src = asset($arField['value']);
                            } else {
                                if (file_exists(sprintf('%s/admin/assets/app/media/img/files/%s.svg',
                                    $_SERVER['DOCUMENT_ROOT'], $format))) {
                                    $src = asset(sprintf('/admin/assets/app/media/img/files/%s.svg', $format));
                                } else {
                                    $src = asset('/admin/assets/app/media/img/files/doc.svg');
                                }
                            }
                            $img = sprintf('<div class="img_block"><div class="img_item">
<a href="%4$s" target="_blank">
<img src="%1$s">
</a>
</div><button class="delete btn btn-secondary btn-sm m-btn m-btn--custom m-btn--label-danger">Удалить</button>
                <input name="%2$s" type="hidden" value="%3$s" id="%2$s"></div>', $src,
                                str_replace($key, sprintf('%s_old', $key), $name), $arField['value'] ?? '',
                                asset($arField['value']));
                        } else {
                            $img = '';
                        }
                        $html = sprintf('<div class="form-group m-form__group row" %6$s>
											<label for="%3$s" class="col-2 col-form-label">
												%1$s
											</label>
											<div class="col-10 ">
											    <div class="custom-file">
												<input class="custom-file-input" name="%2$s" type="file" value="%4$s" id="%3$s">
												<label class="custom-file-label" for="%3$s">Выберите файл</label>
												</div>
												%5$s
											</div>
										</div>
											', $arField['label'], $name, str_replace(['[', ']'], ['_', ''], $name),
                            $arField['value'] ?? '', $img, $showIf);
                    }
                    break;
                case 'number':
                    if (isset($arField['multiple']) && $arField['multiple'] == 'Y') {
                        $inputHtml = '';
                        if (isset($arField['value']) && $arField['value'] && is_array($arField['value'])) {
                            foreach ($arField['value'] as $value) {
                                if (is_array($value)) {
                                    $value = reset($value);
                                }
                                $inputHtml .= sprintf('<div data-repeater-item class="form-group m-form__group row align-items-center">
														<div class="col-md-10">
															<input class="form-control m-input" name="%1$s" value="%2$s" type="number">
															<div class="d-md-none m--margin-bottom-10"></div>
														</div>
														<div class="col-md-2">
															<div data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">
																<span>
																	<i class="la la-trash-o"></i>
																	<span>
																		Удалить
																	</span>
																</span>
															</div>
														</div>
													</div>', $name, $value ?? '');
                            }
                        }
                        $inputHtml .= sprintf('<div data-repeater-item class="form-group m-form__group row align-items-center">
														<div class="col-md-10">
															<input class="form-control m-input" name="%1$s" type="number">
															<div class="d-md-none m--margin-bottom-10"></div>
														</div>
														<div class="col-md-2">
															<div data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">
																<span>
																	<i class="la la-trash-o"></i>
																	<span>
																		Удалить
																	</span>
																</span>
															</div>
														</div>
													</div>', $name);

                        $html = sprintf('<div class="repeater_block" %4$s>
											<div class="form-group  m-form__group row" >
												<label  class="col-lg-2 col-form-label">
													%s:
												</label>
												<div data-repeater-list="%3$s" class="col-lg-10">
												%s
												</div>
											</div>
											<div class="m-form__group form-group row">
												<label class="col-lg-2 col-form-label"></label>
												<div class="col-lg-4">
													<div data-repeater-create="" class="btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
														<span>
															<i class="la la-plus"></i>
															<span>
																Добавить
															</span>
														</span>
													</div>
												</div>
											</div>
										</div>', $arField['label'], $inputHtml, $name, $showIf);
                    } else {
                        $html = sprintf('<div class="form-group m-form__group row" %5$s>
											<label for="%3$s" class="col-2 col-form-label">
												%1$s
											</label>
											<div class="col-10">
												<input class="form-control m-input" name="%2$s" step="0.1" type="number" value="%4$s" id="%3$s">
											</div>
										</div>', $arField['label'], $name, str_replace(['[', ']'], ['_', ''], $name),
                            $arField['value'] ?? '', $showIf);
                    }
                    break;
                case 'boolean':
                    $html = sprintf('<div class="form-group m-form__group row" %5$s>
                                        <label for="%3$s" class="col-2 col-form-label">%1$s</label>
                                        <div class="col-10">
                                            <span class="m-switch m-switch--icon">
                                                <label>
                                                    <input type="checkbox" name="%2$s" id="%3$s" value="1" %4$s>
                                                    <span></span>
                                                </label>
                                            </span>
                                        </div>
                                </div>', $arField['label'], $name, str_replace(['[', ']'], ['_', ''], $name),
                        isset($arField['value']) && $arField['value'] ? 'checked' : '', $showIf);

                    break;
                case 'list':
                    if (isset($arField['model']) && $arField['model'] && class_exists($arField['model'])) {
                        $model = new $arField['model'];
                        $user = Auth::user();

                        if($arField['model'] == 'App\Models\Customer' && !$user->isAdmin()){
                            $arField['values'] = $model->select(['*'])->where('user_id',$user->id)->orderBy('name', 'asc')->get()->toArray();
                        }else{
                            $arField['values'] = $model->select(['*'])->orderBy('name', 'asc')->get()->toArray();
                        }

                    }
                    if (isset($arField['values']) && $arField['values']) {
                        $isMultiple = isset($arField['multiple']) && $arField['multiple'] == 'Y';
                        $arOptions = [];
                        foreach ($arField['values'] as $value) {
                            if ($isMultiple) {
                                if (isset($arField['value']) && in_array($value['id'], $arField['value'])) {
                                    $selected = 'selected';
                                } else {
                                    $selected = '';
                                }
                            } else {
                                if (isset($arField['value']) && isset($value['id']) && $value['id'] == $arField['value']) {
                                    $selected = 'selected';
                                } else {
                                    $selected = '';
                                }
                            }
                            $arOptions[] = sprintf('<option value="%1$s" %2$s>%3$s</option>', $value['id'],
                                $selected,
                                $value[$arField['name_field'] ?? 'name']);
                        }
                        if ($isMultiple) {
                            $name .= '[]';
                        }
                        $html = sprintf('<div class="form-group m-form__group row" %6$s>
											<label for="%3$s" class="col-2 col-form-label">
												%1$s
											</label>
											<div class="col-10">
												<select class="form-control m-select2" id="%3$s" name="%2$s" %5$s>
												<option></option>
												%4$s
												</select>
											</div>
										</div>', $arField['label'], $name, str_replace(['[', ']'], ['_', ''], $name),
                            implode('', $arOptions), $isMultiple ? 'multiple' : '', $showIf);
                    }
                    break;
                case 'password':
                    $html = sprintf('<div class="form-group m-form__group row" %5$s>
											<label for="%3$s" class="col-2 col-form-label">
												%1$s
											</label>
											<div class="col-10">
												<input class="form-control m-input" name="%2$s" type="password" value="%4$s" id="%3$s">
											</div>
										</div>', $arField['label'], $name, str_replace(['[', ']'], ['_', ''], $name,),
                        '', $showIf);
                    break;
                case 'title':
                    $html = sprintf('<div class="form-group m-form__group row" %2$s>
											<div class="col-12">
												%1$s
											</div>

										</div>', $arField['label'], $showIf);
                    break;
                case 'json':
                    if (isset($arField['fields']) && $arField['fields']) {
                        if (isset($arField['label']) && $arField['label']) {
                            $html = sprintf('<div class="form-group m-form__group row">%s</div>', $arField['label']);
                        }
                        if (isset($arField['multiple']) && $arField['multiple'] == 'Y') {
                            $inputHtml = '';
                            if (isset($arField['value']) && is_array($arField['value'])) {
                                foreach ($arField['value'] as $value) {
                                    $fieldHtml = '';
                                    foreach ($arField['fields'] as $keyField => $field) {
                                        $field['value'] = $value[$keyField] ?? '';
                                        $fieldName = sprintf('%s[%s][]', $name, $keyField);
                                        $fieldHtml .= $this->getField($field, $fieldName, $fieldName);
                                    }
                                    $inputHtml .= sprintf('<div data-repeater-item class="form-group m-form__group row align-items-center">
														<div class="col-md-10">
															%s

														</div>
														<div class="col-md-2">
															<div data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">
																<span>
																	<i class="la la-trash-o"></i>
																	<span>
																		Удалить
																	</span>
																</span>
															</div>
														</div>
													</div>', $fieldHtml);
                                }
                            } else {
                                $fieldHtml = '';
                                foreach ($arField['fields'] as $keyField => $field) {
                                    $field['value'] = $arField['value'][$keyField] ?? '';
                                    $fieldName = sprintf('%s[%s][]', $name, $keyField);
                                    $fieldHtml .= $this->getField($field, $fieldName, $fieldName);
                                }
                                $inputHtml .= sprintf('<div data-repeater-item class="form-group m-form__group row align-items-center">
														<div class="col-md-10">
															%s

														</div>
														<div class="col-md-2">
															<div data-repeater-delete="" class="btn-sm btn btn-danger m-btn m-btn--icon m-btn--pill">
																<span>
																	<i class="la la-trash-o"></i>
																	<span>
																		Удалить
																	</span>
																</span>
															</div>
														</div>
													</div>', $fieldHtml);
                            }


                            $html = sprintf('<div class="repeater_block" data-max-items="%4$s">
											<div class="form-group  m-form__group row" >
												<label  class="col-lg-2 col-form-label">
													%s:
												</label>
												<div data-repeater-list="%3$s" class="col-lg-10">
												%s
												</div>
											</div>
											<div class="m-form__group form-group row">
												<label class="col-lg-2 col-form-label"></label>
												<div class="col-lg-4">
													<div data-repeater-create="" class="btn btn btn-sm btn-brand m-btn m-btn--icon m-btn--pill m-btn--wide">
														<span>
															<i class="la la-plus"></i>
															<span>
																Добавить
															</span>
														</span>
													</div>
												</div>
											</div>
										</div>', $arField['label'], $inputHtml, $name, $arField['max_count']);
                        } else {
                            foreach ($arField['fields'] as $keyField => $field) {
                                $field['value'] = $arField['value'][$keyField] ?? '';

                                $fieldName = sprintf('%s[%s]', $name, $keyField);
                                $html .= $this->getField($field, $fieldName, $fieldName);
                            }
                        }

                        $html .= '<hr>';
                    }
                    break;
                case 'properties':

                    $properties = $arField['list']::where($arField['filter'])->get();
                    if ($properties) {
                        $html = sprintf('<div class="form-group m-form__group row">
											<div class="col-2 col-form-label">
												%s
											</div>
										</div>', $arField['label']);

                        foreach ($properties as $property) {
                            $value = '';
                            if (isset($arField['value']) && $arField['value']) {
                                if (is_object($arField['value'])) {
                                    $itemValue = $arField['value']->where('property_id', $property->id)->first();
                                } else {
                                    $itemValue = $arField['value'][$property->id] ?? '';
                                }
                                if ($itemValue) {
                                    $value = $itemValue->value;
                                }
                            }
                            $html .= sprintf('<div class="form-group m-form__group row">
											<label for="name" class="col-2 col-form-label">
												%1$s
											</label>
											<div class="col-10">
												<input type="text" name="%2$s" value="%3$s" class="form-control m-input">
											</div>
										</div>', $property->name, sprintf('%s[%s]', $name, $property->id), $value);
                        }
                    }
                    break;
            }

        return $html;
    }


}

