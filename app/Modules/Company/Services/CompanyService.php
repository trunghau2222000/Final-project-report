<?php

namespace App\Modules\Company\Services;

use App\Helpers\TransformerResponse;
use App\Modules\Company\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Modules\Company\Services\Interfaces\CompanyServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;


class CompanyService implements CompanyServiceInterface
{

    private $transformerResponse;
    private $companyRepository;
    const   ID_NOT_EXIST            =   'id does not exist';
    const   DELETE_FAILED_MESSAGE   =   'Deletion failed' ;

    public function __construct(
        TransformerResponse $transformerResponse,
        CompanyRepositoryInterface $CompanyRepository
    )
    {
        $this->transformerResponse = $transformerResponse;
        $this->companyRepository = $CompanyRepository;
    }

    /**
     * abc
     *
     * @return
     */
    public function getAll()
    {
        try {
            $companies = $this->companyRepository->getAll();
            return $this->transformerResponse->response(
                false,
                [
                    'Compannies' => $companies
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

    public function create($requests)
    {
        try {
            $validated = $requests->validated();
            $company = $this->companyRepository->create($validated);
            return $this->transformerResponse->response(
                false,
                [
                    'Company' => $company
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

    public function update($requests, $id)
    {
        try {

            $validated = $requests->validated();

            // update
            $company = $this->companyRepository->getById($id);
            if(empty($company))
                return $this->transformerResponse->response(
                    true,
                    [],
                    TransformerResponse::HTTP_UNAUTHORIZED,
                    self::ID_NOT_EXIST
                );
            $company = $this->companyRepository->updateById($validated, $id);
            return $this->transformerResponse->response(
                false,
                [
                    'Company' => $company
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

    public function delete($id)
    {
        try {
            $company = $this->companyRepository->getById($id);
            if(empty($company)) {
                return $this->transformerResponse->response(
                    true,
                    [],
                    TransformerResponse::HTTP_NOT_FOUND,
                    self::ID_NOT_EXIST
                );
            }

            if(!$this->companyRepository->deleteById($id)) {
                return $this->transformerResponse->response(
                    true,
                    [],
                    TransformerResponse::HTTP_NO_CONTENT,
                    self::DELETE_FAILED_MESSAGE
                );
            }
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
                TransformerResponse::INTERNAL_SERVER_ERROR_MESSAGE . $exception->getMessage()
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

    public function getCompany($id)
    {
        try {
            $company = $this->companyRepository->getById($id);

            if(empty($company))
                return $this->transformerResponse->response(
                    true,
                    [],
                    TransformerResponse::HTTP_UNAUTHORIZED,
                    self::ID_NOT_EXIST
                );

            return $this->transformerResponse->response(
                false,
                [
                    'Compannies' => $company
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
