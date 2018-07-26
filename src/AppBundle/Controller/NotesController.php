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

    public function getNoteAction($id, Request $request)
    {
        var_dump($this->authService->getUser());
        exit;
        $note = $this->noteRepository->find($id);
        if (!$note) {
            return $this->jsonResponse('@app/error.json.twig', ['errors' => 'Undefined note']);
        }

        return $this->jsonResponse('@app/note.json.twig', ['note' => $note]);
    }

    public function postNoteAction(Request $request)
    {
        $noteData = $request->request->all();
        $validator = new NoteValidator($noteData);
        $validator->validate();

        if ($validator->hasErrors()) {
            return $this->jsonResponse('@app/error.json.twig', ['errors' => $validator->getErrors()]);
        }

        $note = $this->noteRepository->create($noteData);

        return $this->jsonResponse('@app/note.json.twig', ['note' => $note]);
    }

    public function putNoteAction($id, Request $request)
    {
        echo $request;
        exit;
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    public function deleteNoteAction($id, Request $request)
    {
        echo $request;
        exit;
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    public function jsonResponse($view, $data) {
        $response = new Response();
        $response->setContent($this->renderView($view, $data));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
