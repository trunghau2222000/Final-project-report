<?php

namespace App\Modules\Employee\Services;

use App\Helpers\TransformerResponse;
use App\Modules\Company\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Modules\Employee\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Modules\Employee\Services\Interfaces\EmployeeServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;


class EmployeeService implements EmployeeServiceInterface
{

    private $transformerResponse;
    private $employeeRepository;
    private $companyRepository;
    const   ID_NOT_EXIST            =   'id does not exist';
    const   DELETE_FAILED_MESSAGE   =   'Deletion failed' ;

    public function __construct(
        TransformerResponse         $transformerResponse,
        EmployeeRepositoryInterface $employeeRepository,
        CompanyRepositoryInterface  $companyRepository
    )
    {
        $this->transformerResponse = $transformerResponse;
        $this->employeeRepository  = $employeeRepository;
        $this->companyRepository   = $companyRepository;
    }

    /**
     * get all employees
     * @return reponse
     */
    public function getAll()
    {
        try {
            $employees = $this->employeeRepository->getAll();
            return $this->transformerResponse->response(
                false,
                [
                    'Employees' => $employees
                ],
                TransformerResponse::HTTP_OK,
                TransformerResponse::GET_SUCCESS_MESSAGE
            );
        } catch (QueryException $exception) {

            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_INTERNAL_SERVER_ERROR,
                TransformerResponse::INTERNAL_SERVER_ERROR_MESSAGE
            );

        } catch (ModelNotFoundException $exception) {

            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_NOT_FOUND,
                TransformerResponse::NOT_FOUND_MESSAGE
            );
        }

    }

    /**
     * create employee
     * @return reponse
     */
    public function create($requests)
    {
        try {
            $validated = $requests->validated();
            $employee = $this->employeeRepository->create($validated);
            return $this->transformerResponse->response(
                false,
                [
                    'employee' => $employee
                ],
                TransformerResponse::HTTP_CREATED,
                TransformerResponse::CREATE_SUCCESS_MESSAGE
            );
        } catch (QueryException $exception) {

            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_INTERNAL_SERVER_ERROR,
                TransformerResponse::INTERNAL_SERVER_ERROR_MESSAGE
            );

        } catch (ModelNotFoundException $exception) {

            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_NOT_FOUND,
                TransformerResponse::NOT_FOUND_MESSAGE
            );
        }
    }

    /**
     * update employee to by id
     * @return reponse
     */
    public function update($requests, $id)
    {
        try {

            $validated = $requests->validated();
            // check id
            $employee = $this->employeeRepository->getById($id);
            if(empty($employee))
                return $this->transformerResponse->response(
                    true,
                    [],
                    TransformerResponse::HTTP_UNAUTHORIZED,
                    self::ID_NOT_EXIST
                );

            // update
            $employee = $this->employeeRepository->updateById($validated, $id);
            return $this->transformerResponse->response(
                false,
                [
                    'Employee' => $employee
                ],
                TransformerResponse::HTTP_OK,
                TransformerResponse::UPDATE_SUCCESS_MESSAGE
            );
        } catch (QueryException $exception) {

            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_INTERNAL_SERVER_ERROR,
                TransformerResponse::INTERNAL_SERVER_ERROR_MESSAGE
            );

        } catch (ModelNotFoundException $exception) {

            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_NOT_FOUND,
                TransformerResponse::NOT_FOUND_MESSAGE
            );
        }

    }

     /**
     * delete employee to by id
     * @return reponse
     */
    public function delete($id)
    {
        try {
            // check id
            $employee = $this->employeeRepository->getById($id);
            if(empty($employee))
                return $this->transformerResponse->response(
                    true,
                    [],
                    TransformerResponse::HTTP_NOT_FOUND,
                    self::ID_NOT_EXIST
                );
            // check and delete
            if(!$this->employeeRepository->deleteById($id))
                return $this->transformerResponse->response(
                    true,
                    [],
                    TransformerResponse::HTTP_NO_CONTENT,
                    self::DELETE_FAILED_MESSAGE
                );

            return $this->transformerResponse->response(
                false,
                [],
                TransformerResponse::HTTP_OK,
                TransformerResponse::DELETE_SUCCESS_MESSAGE
            );

        } catch (QueryException $exception) {

            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_INTERNAL_SERVER_ERROR,
                TransformerResponse::INTERNAL_SERVER_ERROR_MESSAGE
            );

        } catch (ModelNotFoundException $exception) {

            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_NOT_FOUND,
                TransformerResponse::NOT_FOUND_MESSAGE
            );
        }
    }

    public function getEmployeesToByCompanyId($companyId)
    {
        try {
            $employees = $this->employeeRepository->getByCompanyId($companyId);
            if(empty($employees))
                return $this->transformerResponse->response(
                    true,
                    [],
                    TransformerResponse::HTTP_UNAUTHORIZED,
                    self::ID_NOT_EXIST
                );
            return $this->transformerResponse->response(
                false,
                [
                    'Employees' => $employees
                ],
                TransformerResponse::HTTP_OK,
                TransformerResponse::GET_SUCCESS_MESSAGE
            );
        } catch (QueryException $exception) {

            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_INTERNAL_SERVER_ERROR,
                TransformerResponse::INTERNAL_SERVER_ERROR_MESSAGE
            );

        } catch (ModelNotFoundException $exception) {

            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_NOT_FOUND,
                TransformerResponse::NOT_FOUND_MESSAGE
            );
        }
    }

    public function getEmployee($id)
    {
        try {
            $employee = $this->employeeRepository->getById($id);

            if(empty($employee))
                return $this->transformerResponse->response(
                    true,
                    [],
                    TransformerResponse::HTTP_UNAUTHORIZED,
                    self::ID_NOT_EXIST
                );

            return $this->transformerResponse->response(
                false,
                [
                    'Employee' => $employee
                ],
                TransformerResponse::HTTP_OK,
                TransformerResponse::GET_SUCCESS_MESSAGE
            );
        } catch (QueryException $exception) {

            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_INTERNAL_SERVER_ERROR,
                TransformerResponse::INTERNAL_SERVER_ERROR_MESSAGE
            );

        } catch (ModelNotFoundException $exception) {

            return $this->transformerResponse->response(
                true,
                [],
                TransformerResponse::HTTP_NOT_FOUND,
                TransformerResponse::NOT_FOUND_MESSAGE
            );
        }
    }

}
