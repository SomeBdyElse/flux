
/**
 * Keeps track of the element count and max-items
 * for each column. Enables/Disables new ce buttons
 * accordingly.
 *
 * To be used in the TYPO3 BE Page Module
 */
define(['jquery'], function ($) {

    var MaxElements = {};

    MaxElements.initialize = function() {
        this.update();

        var maxElements = this;
        $('.flux-grid .t3-page-ce-wrapper[data-max-elements]').on('childrenChanged', function() {
            maxElements.update();
        })
    };

    MaxElements.update = function() {
        var $columns = $('.flux-grid .t3-page-ce-wrapper[data-max-elements]');
        $columns.each(function() {
            var $column = $(this);
            var maxElements = parseInt($column.data('maxElements'));
            var numberOfChildren = $column
                .find('.t3-page-ce[data-table]:not(.dragged-item):not(.dragged-helper)')
                .length
            ;

            $column.attr('data-children', numberOfChildren);

            if(numberOfChildren >= maxElements) {
                $column.find('.t3js-page-new-ce, .t3-page-ce-wrapper-new-ce').hide();
                $column.addClass('full');
            } else {
                $column.find('.t3js-page-new-ce, .t3-page-ce-wrapper-new-ce').show();
                $column.removeClass('full');
            }
        })
    };

    /**
     * initialize function
     */
    return function() {
        MaxElements.initialize();
        return MaxElements;
    }();
});