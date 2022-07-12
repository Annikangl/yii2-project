<?php


namespace app\forms;


use app\models\Interview;
use yii\base\Model;

class EmployeeCreateForm extends Model
{
    public string $firstName;
    public string $lastName;
    public string $address;
    public string $email;
    public string $orderDate;
    public string $contractDate;
    public string $recruitDate;

    private Interview $interview;

    public function __construct(Interview $interview = null, $config = [])
    {
        $this->interview = $interview;

        if ($this->interview) {
            $this->firstName = $this->interview->first_name;
            $this->lastName = $this->interview->last_name;
            $this->email = $this->interview->email;
        }
        $this->orderDate = date('Y-m-d');
        $this->contractDate = date('Y-m-d');
        $this->recruitDate = date('Y-m-d');

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['first_name', 'last_name', 'email', 'address'], 'required'],
            [['email'], 'email'],
            [['first_name', 'last_name', 'email', 'address'], 'string', 'max' => 255],
            [['orderDate', 'contractDate', 'recruitDate'], 'required'],
            [['orderDate', 'contractDate', 'recruitDate'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'orderDate' => 'Order Date',
            'contractDate' => 'Contract Date',
            'recruitDate' => 'Recruit Date',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'address' => 'Address',
            'email' => 'Email',
        ];
    }
}