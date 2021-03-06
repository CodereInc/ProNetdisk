import $ from 'mdui.jq/es/$';
import extend from 'mdui.jq/es/functions/extend';
import 'mdui.jq/es/methods/addClass';
import 'mdui.jq/es/methods/children';
import 'mdui.jq/es/methods/each';
import 'mdui.jq/es/methods/eq';
import 'mdui.jq/es/methods/first';
import 'mdui.jq/es/methods/hasClass';
import 'mdui.jq/es/methods/height';
import 'mdui.jq/es/methods/is';
import 'mdui.jq/es/methods/on';
import 'mdui.jq/es/methods/parent';
import 'mdui.jq/es/methods/parents';
import 'mdui.jq/es/methods/removeClass';
import { isNumber } from 'mdui.jq/es/utils';
import '../../jq_extends/methods/reflow';
import '../../jq_extends/methods/transition';
import '../../jq_extends/methods/transitionEnd';
import { componentEvent } from '../../utils/componentEvent';
const DEFAULT_OPTIONS = {
    accordion: false,
};
class CollapseAbstract {
    constructor(selector, options = {}) {
        /**
         * 配置参数
         */
        this.options = extend({}, DEFAULT_OPTIONS);
        // CSS 类名
        const classPrefix = `mdui-${this.getNamespace()}-item`;
        this.classItem = classPrefix;
        this.classItemOpen = `${classPrefix}-open`;
        this.classHeader = `${classPrefix}-header`;
        this.classBody = `${classPrefix}-body`;
        this.$element = $(selector).first();
        extend(this.options, options);
        this.bindEvent();
    }
    /**
     * 绑定事件
     */
    bindEvent() {
        // eslint-disable-next-line @typescript-eslint/no-this-alias
        const that = this;
        // 点击 header 时，打开/关闭 item
        this.$element.on('click', `.${this.classHeader}`, function () {
            const $header = $(this);
            const $item = $header.parent();
            const $items = that.getItems();
            $items.each((_, item) => {
                if ($item.is(item)) {
                    that.toggle(item);
                }
            });
        });
        // 点击关闭按钮时，关闭 item
        this.$element.on('click', `[mdui-${this.getNamespace()}-item-close]`, function () {
            const $target = $(this);
            const $item = $target.parents(`.${that.classItem}`).first();
            that.close($item);
        });
    }
    /**
     * 指定 item 是否处于打开状态
     * @param $item
     */
    isOpen($item) {
        return $item.hasClass(this.classItemOpen);
    }
    /**
     * 获取所有 item
     */
    getItems() {
        return this.$element.children(`.${this.classItem}`);
    }
    /**
     * 获取指定 item
     * @param item
     */
    getItem(item) {
        if (isNumber(item)) {
            return this.getItems().eq(item);
        }
        return $(item).first();
    }
    /**
     * 触发组件事件
     * @param name 事件名
     * @param $item 事件触发的目标 item
     */
    triggerEvent(name, $item) {
        componentEvent(name, this.getNamespace(), $item, this);
    }
    /**
     * 动画结束回调
     * @param $content body 元素
     * @param $item item 元素
     */
    transitionEnd($content, $item) {
        if (this.isOpen($item)) {
            $content.transition(0).height('auto').reflow().transition('');
            this.triggerEvent('opened', $item);
        }
        else {
            $content.height('');
            this.triggerEvent('closed', $item);
        }
    }
    /**
     * 打开指定面板项
     * @param item 面板项的索引号、或 CSS 选择器、或 DOM 元素、或 JQ 对象
     */
    open(item) {
        const $item = this.getItem(item);
        if (this.isOpen($item)) {
            return;
        }
        // 关闭其他项
        if (this.options.accordion) {
            this.$element.children(`.${this.classItemOpen}`).each((_, element) => {
                const $element = $(element);
                if (!$element.is($item)) {
                    this.close($element);
                }
            });
        }
        const $content = $item.children(`.${this.classBody}`);
        $content
            .height($content[0].scrollHeight)
            .transitionEnd(() => this.transitionEnd($content, $item));
        this.triggerEvent('open', $item);
        $item.addClass(this.classItemOpen);
    }
    /**
     * 关闭指定面板项
     * @param item 面板项的索引号、或 CSS 选择器、或 DOM 元素、或 JQ 对象
     */
    close(item) {
        const $item = this.getItem(item);
        if (!this.isOpen($item)) {
            return;
        }
        const $content = $item.children(`.${this.classBody}`);
        this.triggerEvent('close', $item);
        $item.removeClass(this.classItemOpen);
        $content
            .transition(0)
            .height($content[0].scrollHeight)
            .reflow()
            .transition('')
            .height('')
            .transitionEnd(() => this.transitionEnd($content, $item));
    }
    /**
     * 切换指定面板项的打开状态
     * @param item 面板项的索引号、或 CSS 选择器、或 DOM 元素、或 JQ 对象
     */
    toggle(item) {
        const $item = this.getItem(item);
        this.isOpen($item) ? this.close($item) : this.open($item);
    }
    /**
     * 打开所有面板项
     */
    openAll() {
        this.getItems().each((_, element) => this.open(element));
    }
    /**
     * 关闭所有面板项
     */
    closeAll() {
        this.getItems().each((_, element) => this.close(element));
    }
}
export { CollapseAbstract };
