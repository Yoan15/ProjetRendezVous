<?php

namespace App\Controller;

use App\DTO\RdvDTO;
use App\Entity\Rdv;
use App\Mapper\RdvMapper;
use App\Service\RdvService;
use FOS\RestBundle\View\View;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\Exception\RdvServiceException;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Put;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use OpenApi\Annotations as OA;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RequestParam;

class RdvRestController extends AbstractFOSRestController
{

    private $rdvService;

    const URI_RDV_COLLECTION = "/rdvs";
    const URI_RDV_INSTANCE = "/rdvs/{id}";

    public function __construct(RdvService $rdvService, EntityManagerInterface $entityManager, RdvMapper $mapper)
    {
        $this->rdvService = $rdvService;
        $this->entityManager = $entityManager;
        $this->rdvMapper = $mapper;
    }

    /**
     * /**
     * @OA\Get(
     *     path="/rdvs",
     *     tags={"Rdv"},
     *     summary="Returns a list of RdvDTO",
     *     description="Returns a list of RdvDTO",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation", 
     *         @OA\JsonContent(ref="#/components/schemas/RdvDTO")   
     *     ),
     *      @OA\Response(
     *         response=404,
     *         description="If no RdvDTO found",    
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us",    
     *     )
     * )
     * 
     * @Get(RdvRestController::URI_RDV_COLLECTION)
     */
    public function searchAll()
    {
        try{
            $rdvs = $this->rdvService->searchAll();
        }catch(RdvServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if($rdvs){
            return View::create($rdvs, Response::HTTP_OK, ["Content-type" => "application/json"]);
        }else{
            return View::create($rdvs, Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Delete(
     *     path="/rdvs/{rdvId}",
     *     tags={"Rdv"},
     *     summary="Deletes a rdv",
     *     description="Deletes a single rdv",
     *     operationId="deleteRdv",
     *     @OA\Parameter(
     *         name="rdvId",
     *         in="path",
     *         description="Rdv id to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Rdv not found",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error, please contact us.",
     *     )
     * )
     * 
     * @Delete(RdvRestController::URI_RDV_INSTANCE)
     * @param [type] $id
     * @return void
     */
    public function remove(Rdv $rdv){
        try{
            $this->rdvService->delete($rdv);
            return View::create([], Response::HTTP_NO_CONTENT, ["Content-type" => "application/json"]);
        }catch(RdvServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Post(
     *     path="/rdvs",
     *     tags={"Rdv"},
     *     summary="Creates a rdv",
     *     description="Creates a rdv",
     *     @OA\Response(
     *         response=201,
     *         description="Rdv created", 
     *         @OA\JsonContent(ref="#/components/schemas/RdvDTO")   
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server Error. Please contact us",    
     *     )
     * )
     * 
     * @Post(RdvRestController::URI_RDV_COLLECTION)
     * @ParamConverter("rdvDto", converter="fos_rest.request_body")
     * @return void
    */
    public function create(RdvDTO $rdvDto){
        try{
            $this->rdvService->persist(new Rdv(), $rdvDto);
            return View::create([], Response::HTTP_CREATED, ["Content-type" => "application/json"]);
        }catch(RdvServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Put(
     *     path="/rdvs/{rdvId}",
     *     tags={"Rdv"},
     *     summary="Update a rdv",
     *     description="Updates a single rdv",
     *     operationId="updateRdv",
     *     @OA\Parameter(
     *         name="rdvId",
     *         in="path",
     *         description="Rdv id to update",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Rdv updated"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error, please contact us."
     *     )
     * )
     * 
     * @Put(RdvRestController::URI_RDV_INSTANCE)
     * @ParamConverter("rdvDto", converter="fos_rest.request_body")
     * @param RdvDTO $rdvDto
     * @return void
     */
    public function update(Rdv $rdv, RdvDTO $rdvDto){
        try{
            $this->rdvService->persist($rdv, $rdvDto);
            return View::create([], Response::HTTP_OK, ["Content-type" => "application/json"]);
        }catch(RdvServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
    }

    /**
     * @OA\Get(
     *     path="/rdvs/{rdvId}",
     *     tags={"Rdv"},
     *     summary="Find rdv by ID",
     *     description="Returns a single rdv",
     *     operationId="getRdvById",
     *     @OA\Parameter(
     *         name="rdvId",
     *         in="path",
     *         description="ID of rdv to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/RdvDTO"),
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Rdv not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error, please contact us."
     *     ),
     * )
     * 
     * @Get(RdvRestController::URI_RDV_INSTANCE)
     * @return void
     */
    public function searchById(int $id){
        try{
            $rdvDto = $this->rdvService->searchById($id);
        }catch(RdvServiceException $e){
            return View::create($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR, ["Content-type" => "application/json"]);
        }
        if($rdvDto){
            return View::create($rdvDto, Response::HTTP_OK, ["Content-type" => "application/json"]);
        }else{
            return View::create([], Response::HTTP_NOT_FOUND, ["Content-type" => "application/json"]);
        }
    }
}
