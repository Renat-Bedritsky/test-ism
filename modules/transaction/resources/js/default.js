$(document).on('input', '#input-name', userSearch);
$(document).on('click', '.option', userSelection);

/**
 * User search.
 */
function userSearch() {
    const name = this.value;

    $.post(`/transactions/search`, {name: name}).done(function(response) {
        let $data = JSON.parse(response);

        let $userList = $('#user-list');
        $userList.children().remove();

        $.each($data, function() {
            let id = $(this)[0].id;
            let name = $(this)[0].name;
            let $newName = `<div class="option" data-id="${id}">${name}</div>`;

            $userList.append($newName);
        });
    });
}

/**
 * User selection.
 */
function userSelection() {
    let userId = $(this).data('id');
    let userName = $(this).text();

    $.post(`/transactions/get`, {userId: userId}).done(function(response) {
        let $dataByMonth = JSON.parse(response);

        $('#field-for-name').text(userName);
        fillOutTheTable($dataByMonth);
    });
}

/**
 * Displays the selected user's data in a table.
 * @param $dataByMonth
 */
function fillOutTheTable($dataByMonth) {
    let $table = $('#transaction-list').children('tbody');
    $table.children().remove();

    $.each($dataByMonth, function() {
        let month = $(this)[0].month;
        let money = $(this)[0].money;

        let $newStr = `
                <tr>
                    <td>${month}</td>
                    <td>${money}</td>
                </tr>
            `;

        $table.append($newStr);
    });
}