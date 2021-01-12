<?php

namespace App\Controller;

use App\DTO\SpecialiteDTO;
use App\Entity\Specialite;
use FOS\RestBundle\View\View;
use App\Mapper\SpecialiteMapper;
use App\Service\SpecialiteService;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations\Delete;
use App\Service\Exception\SpecialiteServiceException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class SpecialiteRestController extends AbstractFOSRestController
{
    private $specialiteService;

    const URI_SPECIALITE_COLLECTION = "/specialites";
    const URI_SPECIALITE_INSTANCE = "/specialites/{id}";

    public function __construct(SpecialiteService $specialiteService, EntityManagerInterface $entityManager, SpecialiteMapper $mapper)
    {
        $this->specialiteService = $specialiteService;
        $this->entityManager = $entityManager;
        $this->specialiteMapper = $mapper;
    }

    /**
     * @OA\Get(
     *     path="/specialites",
     *     tags={"Spécialité"},
     *     summary="Returns a list of SpecialiteDTO",
     *     description="Returns a list of SpecialiteDTO",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation", 
     *         @OA\JsonContent(ref="#/components/schemas/SpecialiteDTO")   
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="If no SpecialiteDTO found",    
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us",    
     *     )
     * )
     * 
     * @Get(SpecialiteRestController::URI_SPECIALITE_COLLECTION)
     */
    public function searchAll()
    {
        try{
            $specialites = $this->specialiteService->searchAll();
        }catch(SpecialiteServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if($specialites){
            return View::create($specialites, Response::HTTP_OK, ["Content-type" => "application/json"]);
        }else{
            return View::create($specialites, Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Delete(
     *     path="/specialite/{specialiteId}",
     *     tags={"Spécialité"},
     *     summary="Deletes a specialite",
     *     description="Deletes a single specialite",
     *     operationId="deleteSpecialite",
     *     @OA\Parameter(
     *         name="specialiteId",
     *         in="path",
     *         description="Spécialité id to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Spécialité not found",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error, please contact us.",
     *     )
     * )
     * 
     * @Delete(SpecialiteRestController::URI_SPECIALITE_INSTANCE)
     * @param [type] $id
     * @return void
     */
    public function remove(Specialite $specialite)
    {
        try{
            $this->specialiteService->delete($specialite);
            return View::create([], Response::HTTP_NO_CONTENT, ["Content-type" => "application/json"]);
        }catch(SpecialiteServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Post(
     *     path="/specialites",
     *     tags={"Spécialité"},
     *     summary="Creates a spécialité",
     *     description="Creates a spécialité",
     *     @OA\Response(
     *         response=201,
     *         description="Spécialité created", 
     *         @OA\JsonContent(ref="#/components/schemas/SpecialiteDTO")   
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us",    
     *     )
     * )
     * 
     * @Post(SpecialiteRestController::URI_SPECIALITE_COLLECTION)
     * @ParamConverter("specialiteDto", converter="fos_rest.request_body")
     * @return void
     */
    public function create(SpecialiteDTO $specialiteDto)
    {
        try{
            $this->specialiteService->persist(new Specialite(), $specialiteDto);
            return View::create([], Response::HTTP_CREATED, ["Content-type" => "application/json"]);
        }catch(SpecialiteServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Put(
     *     path="/specialite/{specialiteId}",
     *     tags={"Spécialité"},
     *     summary="Update a spécialité",
     *     description="Updates a single spécialité",
     *     operationId="updateSpecialite",
     *     @OA\Parameter(
     *         name="specialiteId",
     *         in="path",
     *         description="Spécialité id to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Spécialité updated"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error, please contact us."
     *     )
     * )
     * 
     * @Put(SpecialiteRestController::URI_SPECIALITE_INSTANCE)
     * @ParamConverter("specialiteDto", converter="fos_rest.request_body")
     * @param SpecialiteDTO $specialiteDto
     * @return void
     */
    public function update(Specialite $specialite, SpecialiteDTO $specialiteDto)
    {
        try{
            $this->specialiteService->persist($specialite, $specialiteDto);
            return View::create([], Response::HTTP_OK, ["Content-type" => "application/json"]);
        }catch(SpecialiteServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Get(
     *     path="/specialite/{specialiteId}",
     *     tags={"Spécialité"},
     *     summary="Find spécialité by ID",
     *     description="Returns a single spécialité",
     *     operationId="getSpecialiteById",
     *     @OA\Parameter(
     *         name="specialiteId",
     *         in="path",
     *         description="ID of spécialité to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/SpecialiteDTO"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Spécialité not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error, please contact us."
     *     ),
     * )
     * 
     * @Get(SpecialiteRestController::URI_SPECIALITE_INSTANCE)
     */
    public function searchById(int $id)
    {
        try{
            $specialiteDto = $this->specialiteService->searchById($id);
        }catch(SpecialiteServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if($specialiteDto){
            return View::create($specialiteDto, Response::HTTP_OK, ["Content-type" => "application/json"]);
        }else{
            return View::create([], Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }
}
