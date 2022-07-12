<?php


namespace app\services;


use app\dispatchers\interfaces\EventDispatcherInterface;
use app\models\Contract;
use app\models\Employee;
use app\models\Order;
use app\models\Recruit;
use app\repository\ContractRepository;
use app\repository\EmployeeRepository;
use app\repository\InterviewRepository;
use app\repository\RecruitRepository;
use app\services\dto\RecruitData;

class EmployeeService
{
    private EmployeeRepository $employeeRepository;
    private InterviewRepository $interviewRepository;
    private ContractRepository $contractRepository;
    private RecruitRepository $recruitRepository;
    private TransactionManager $transactionManager;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(
        $employeeRepository,
        $interviewRepository,
        $transactionManager,
        $contractRepository,
        $recruitRepository,
        $eventDispatcher)
    {
        $this->employeeRepository = $employeeRepository;
        $this->interviewRepository = $interviewRepository;
        $this->contractRepository = $contractRepository;
        $this->recruitRepository = $recruitRepository;
        $this->eventDispatcher = $eventDispatcher;
        $this->transactionManager = $transactionManager;
    }

    public function create(dto\RecruitData $data, $orderDate, $contractDate, $recruitDate): ?Employee
    {
        $employee = Employee::create(
            $data->firstName,
            $data->lastName,
            $data->address,
            $data->email
        );
        $contract = Contract::create($employee, $data->lastName, $data->firstName, $contractDate);
        $recruit = Recruit::create($employee, Order::create($orderDate), $recruitDate);

        $transaction = $this->transactionManager->execute(function () use ($employee, $contract, $recruit) {
            $this->employeeRepository->add($employee);
            $this->contractRepository->add($contract);
            $this->recruitRepository->add($recruit);
        });


        $this->eventDispatcher->dispatch(new EmployeeRecruitEvent($employee));
        return $employee;
    }

    public function createByInterview($interviewId, RecruitData $data, $orderDate, $contractDate, $recruitDate): ?Employee
    {
        $interview = $this->interviewRepository->find($interviewId);
        $employee = Employee::create(
            $data->firstName,
            $data->lastName,
            $data->address,
            $data->email
        );

        $interview->passBy($employee);

        $contract = Contract::create($employee, $data->lastName, $data->firstName, $contractDate);
        $recruit = Recruit::create($employee, Order::create($orderDate), $recruitDate);

        $transaction = $this->transactionManager->execute(function () use ($interview, $employee, $contract, $recruit) {
            $this->interviewRepository->save($interview);
            $this->employeeRepository->add($employee);
            $this->contractRepository->add($contract);
            $this->recruitRepository->add($recruit);
        });


        $this->eventDispatcher->dispatch(new EmployeeRecruitByInterviewEvent($employee, $interview));
        return $employee;
    }


}