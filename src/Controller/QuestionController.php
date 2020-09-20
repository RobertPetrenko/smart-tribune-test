<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use App\Entity\Question;
use App\Form\QuestionType;

class QuestionController extends AbstractController
{
    /**
     * @Route("/question", name="create", methods={"POST"})
     */
    public function create(Request $request, SerializerInterface $serializer)
    {
        $request = Request::createFromGlobals();

        $data = json_decode($request->getContent(), true);
        
        $form = $this->createForm(QuestionType::class, new Question());

        $form->submit($data);

        if (!$form->isValid()) {
            return new JsonResponse([], Response::HTTP_BAD_REQUEST);
        }

        $question = $form->getData();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($question);
        $entityManager->flush();

        $jsonContent = $serializer->serialize($question, 'json', ['groups' => 'show_question']);

        return new Response($jsonContent, Response::HTTP_CREATED, [
            'content-type' => 'application/json'
        ]);
    }

    /**
     * @Route("/question/{question}", name="update", methods={"PUT"}, requirements={"question"="\d+"})
     * @param Question $question
     *
     * @return JsonResponse
     */
    public function put(Request $request, Question $question, SerializerInterface $serializer)
    {
        $question = $serializer->deserialize($request->getContent(), Question::class, 'json', [
            'groups' => 'update_question',
            AbstractNormalizer::OBJECT_TO_POPULATE => $question
        ]);
        
        // $form = $this->createForm(QuestionType::class, $question, [
        //     "method" => "PUT"
        // ]);

        // $form->submit($question);

        // if (!$form->isValid()) {
        //     return new JsonResponse([], Response::HTTP_BAD_REQUEST);
        // }

        // $question = $form->getData();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($question);
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
