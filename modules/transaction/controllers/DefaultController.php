<?php

require_once 'modules/transaction/models/Users.php';
require_once 'modules/transaction/models/UserAccounts.php';
require_once 'modules/transaction/models/Transactions.php';

class DefaultController extends Controller
{
    public function actionIndex(): string
    {
        $user = new Users();

        return $this->render('index', [
            'users' => $user->getUsers(),
        ]);
    }

    /**
     * User search.
     * @return void
     */
    public function actionSearch()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            $name = $_POST['name'];
            $user = new Users();
            $result = $user->searchUsers($name);

            echo json_encode($result);
            exit();
        }
    }

    /**
     * Returns user transactions.
     * @return void
     * @throws Exception
     */
    public function actionGetTransactions()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            $modelTransaction = new Transactions();

            $userId = $_POST['userId'];
            $transactions = $modelTransaction->getTransaction($userId);

            $dataByMonth = $this->dataByMonth($userId, $transactions);

            echo json_encode($dataByMonth);
            exit();
        }
    }

    /**
     * Distributes data by month.
     * @param $userId
     * @param $transactions
     * @return array
     * @throws Exception
     */
    private function dataByMonth($userId, $transactions): array
    {
        $dataByMonth = [];
        $monthMarker = 'January';
        $money = 0;

        foreach ($transactions as $transaction) {
            $date = new DateTimeImmutable($transaction['trdate']);
            $month = $date->format('F');

            if ($month !== $monthMarker || $transactions[array_key_last($transactions)]['id'] === $transaction['id']) {
                $dataByMonth[] = ['month' => $monthMarker, 'money' => $money];

                $monthMarker = $month;
                $money = 0;
            }

            if ($transaction['account_to'] === $userId) {
                $money += (int) $transaction['amount'];
            } else if ($transaction['account_from'] === $userId) {
                $money -= (int) $transaction['amount'];
            }
        }

        return $dataByMonth;
    }
}
