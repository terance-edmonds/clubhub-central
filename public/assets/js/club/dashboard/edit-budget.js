const resetBudgetAttributes = () => {
    const budgets = $('.budget-form-section');

    if (budgets.length === 2) {
        budgets.each(function () {
            $(this).find('.remove-budget-btn').prop('disabled', true);
        });
    } else {
        budgets.each(function () {
            $(this).find('.remove-budget-btn').prop('disabled', false);
        });
    }
};

const onAddNewBudget = () => {
    const budget = $('.budget-template');
    const clone = budget.clone();
    const budget_name = new Date().getTime().toString();
    const element = clone.html().replaceAll('{{budget_name}}', budget_name);

    clone
        .html(element)
        .attr('id', budget_name)
        .removeClass('budget-template')
        .insertAfter('#event-budgets-section');

    resetBudgetAttributes();
};

const onRemoveBudget = (budget_name) => {
    const budgets = $('.budget-form-section');
    if (budgets.length !== 1) {
        $(`#${budget_name}`).remove();
    }

    resetBudgetAttributes();
};

$(document).ready(() => {
    if ($('.budget-form-section').length === 1) {
        onAddNewBudget();
    }
});
