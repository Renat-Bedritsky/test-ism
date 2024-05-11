<?php

require_once 'modules/transaction/assets/DefaultAsset.php';

/**
 * @var View $this
 * @var array $users
 */

?>

<form id="form-search">
    <label for="input-name">Name</label>
    <input id="input-name" type="text" list="options" class="form-control">
    <div id="user-list" class="form-control">
        <?php foreach ($users as $user) : ?>
            <div class="option" data-id="<?= $user['id'] ?>"><?= $user['name'] ?></div>
        <?php endforeach; ?>
    </div>
</form>

<div id="transactions">
    <h3 id="field-for-name"></h3>
    <table id="transaction-list" class="table">
        <thead>
            <tr>
                <th scope="col">Date</th>
                <th scope="col">Amount</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

<?php

new DefaultAsset();
