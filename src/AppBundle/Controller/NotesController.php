<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Note;
use AppBundle\Repository\NoteRepositoryInterface;
use AppBundle\Services\AuthService;
use AppBundle\Services\NoteValidator;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotesController extends Controller
{
    private $noteRepository;
    private $authService;

    public function __construct(NoteRepositoryInterface $noteRepository, AuthService $authService)
    {
        $this->noteRepository = $noteRepository;
        $this->authService = $authService;
    }

    public function getNoteAction($id)
    {
        if (!$this->authService->getUser()) {
            return $this->jsonResponse('@app/error.json.twig', ['errors' => 'Unauthorized user'], 401);
        }

        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            return $this->jsonResponse('@app/error.json.twig', ['errors' => 'Id is not integer'], 401);
        }

        $note = $this->noteRepository->findById($id);
        if (!$note) {
            return $this->jsonResponse('@app/error.json.twig', ['errors' => 'Undefined note'], 404);
        }

        return $this->jsonResponse('@app/note.json.twig', ['note' => $note]);
    }

    public function postNoteAction(Request $request)
    {
        if (!$this->authService->getUser()) {
            return $this->jsonResponse('@app/error.json.twig', ['errors' => 'Unauthorized user'], 401);
        }

        $noteData = ['title' => $request->request->get('title'), 'note' => $request->request->get('note')];
        $validator = new NoteValidator($noteData);
        $validator->validate();

        if ($validator->hasErrors()) {
            return $this->jsonResponse('@app/error.json.twig', ['errors' => $validator->getErrors()], 400);
        }

        $note = $this->noteRepository->create($noteData, $this->authService->getUser());

        return $this->jsonResponse('@app/note.json.twig', ['note' => $note]);
    }

    public function putNoteAction($id, Request $request)
    {
        if (!$this->authService->getUser()) {
            return $this->jsonResponse('@app/error.json.twig', ['errors' => 'Unauthorized user'], 401);
        }

        $noteData = [
            'id' => $id,
            'title' => $request->request->get('title'),
            'note' => $request->request->get('note')
        ];
        $validator = new NoteValidator($noteData);
        $validator->validate();

        if ($validator->hasErrors()) {
            return $this->jsonResponse('@app/error.json.twig', ['errors' => $validator->getErrors()], 400);
        }

        $note = $this->noteRepository->update($noteData, $this->authService->getUser());

        return $this->jsonResponse('@app/note.json.twig', ['note' => $note]);
    }

    public function deleteNoteAction($id, Request $request)
    {
        if (!$this->authService->getUser()) {
            return $this->jsonResponse('@app/error.json.twig', ['errors' => 'Unauthorized user'], 401);
        }

        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            return $this->jsonResponse('@app/error.json.twig', ['errors' => 'Id is not integer'], 400);
        }

        $this->noteRepository->delete($id, $this->authService->getUser());

        return $this->jsonResponse(null, []);
    }

    public function jsonResponse($view, array $data, $code = 200) {
        $data['status'] = $code === 200 ? true : false;
        $response = new Response($view ? $this->renderView($view, $data) : json_encode($data), $code);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
