import extend from 'mdui.jq/es/functions/extend';
import 'mdui.jq/es/methods/find';
import 'mdui.jq/es/methods/on';
import 'mdui.jq/es/methods/val';
import { isFunction, isUndefined } from 'mdui.jq/es/utils';
import mdui from '../../mdui';
import '../textfield';
import './dialog';
const DEFAULT_OPTIONS = {
    confirmText: 'ok',
    cancelText: 'cancel',
    history: true,
    modal: false,
    closeOnEsc: true,
    closeOnCancel: true,
    closeOnConfirm: true,
    type: 'text',
    maxlength: 0,
    defaultValue: '',
    confirmOnEnter: false,
};
mdui.prompt = function (label, title, onConfirm, onCancel, options) {
    if (isFunction(title)) {
        options = onCancel;
        onCancel = onConfirm;
        onConfirm = title;
        title = '';
    }
    if (isUndefined(onConfirm)) {
        // eslint-disable-next-line @typescript-eslint/no-empty-function
        onConfirm = () => { };
    }
    if (isUndefined(onCancel)) {
        // eslint-disable-next-line @typescript-eslint/no-empty-function
        onCancel = () => { };
    }
    if (isUndefined(options)) {
        options = {};
    }
    options = extend({}, DEFAULT_OPTIONS, options);
    const content = '<div class="mdui-textfield">' +
        (label ? `<label class="mdui-textfield-label">${label}</label>` : '') +
        (options.type === 'text'
            ? `<input class="mdui-textfield-input" type="text" value="${options.defaultValue}" ${options.maxlength ? 'maxlength="' + options.maxlength + '"' : ''}/>`
            : '') +
        (options.type === 'textarea'
            ? `<textarea class="mdui-textfield-input" ${options.maxlength ? 'maxlength="' + options.maxlength + '"' : ''}>${options.defaultValue}</textarea>`
            : '') +
        '</div>';
    const onCancelClick = (dialog) => {
        const value = dialog.$element.find('.mdui-textfield-input').val();
        onCancel(value, dialog);
    };
    const onConfirmClick = (dialog) => {
        const value = dialog.$element.find('.mdui-textfield-input').val();
        onConfirm(value, dialog);
    };
    return mdui.dialog({
        title,
        content,
        buttons: [
            {
                text: options.cancelText,
                bold: false,
                close: options.closeOnCancel,
                onClick: onCancelClick,
            },
            {
                text: options.confirmText,
                bold: false,
                close: options.closeOnConfirm,
                onClick: onConfirmClick,
            },
        ],
        cssClass: 'mdui-dialog-prompt',
        history: options.history,
        modal: options.modal,
        closeOnEsc: options.closeOnEsc,
        onOpen: (dialog) => {
            // ??????????????????
            const $input = dialog.$element.find('.mdui-textfield-input');
            mdui.updateTextFields($input);
            // ??????????????????
            $input[0].focus();
            // ?????????????????????????????????????????????????????????????????????
            if (options.type !== 'textarea' && options.confirmOnEnter === true) {
                $input.on('keydown', (event) => {
                    if (event.keyCode === 13) {
                        const value = dialog.$element.find('.mdui-textfield-input').val();
                        onConfirm(value, dialog);
                        if (options.closeOnConfirm) {
                            dialog.close();
                        }
                        return false;
                    }
                    return;
                });
            }
            // ????????????????????????????????????????????? input ??????????????????????????????
            if (options.type === 'textarea') {
                $input.on('input', () => dialog.handleUpdate());
            }
            // ????????????????????????????????????????????? DOM ???????????????????????????????????????
            if (options.maxlength) {
                dialog.handleUpdate();
            }
        },
    });
};
