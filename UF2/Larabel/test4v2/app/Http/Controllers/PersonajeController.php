<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePersonajeRequest;
use App\Http\Requests\UpdatePersonajeRequest;
use App\Repositories\PersonajeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class PersonajeController extends AppBaseController
{
    /** @var  PersonajeRepository */
    private $personajeRepository;

    public function __construct(PersonajeRepository $personajeRepo)
    {
        $this->personajeRepository = $personajeRepo;
    }

    /**
     * Display a listing of the Personaje.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $personajes = $this->personajeRepository->all();

        return view('personajes.index')
            ->with('personajes', $personajes);
    }

    /**
     * Show the form for creating a new Personaje.
     *
     * @return Response
     */
    public function create()
    {
        return view('personajes.create');
    }

    /**
     * Store a newly created Personaje in storage.
     *
     * @param CreatePersonajeRequest $request
     *
     * @return Response
     */
    public function store(CreatePersonajeRequest $request)
    {
        $input = $request->all();

        $personaje = $this->personajeRepository->create($input);

        Flash::success('Personaje saved successfully.');

        return redirect(route('personajes.index'));
    }

    /**
     * Display the specified Personaje.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $personaje = $this->personajeRepository->find($id);

        if (empty($personaje)) {
            Flash::error('Personaje not found');

            return redirect(route('personajes.index'));
        }

        return view('personajes.show')->with('personaje', $personaje);
    }

    /**
     * Show the form for editing the specified Personaje.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $personaje = $this->personajeRepository->find($id);

        if (empty($personaje)) {
            Flash::error('Personaje not found');

            return redirect(route('personajes.index'));
        }

        return view('personajes.edit')->with('personaje', $personaje);
    }

    /**
     * Update the specified Personaje in storage.
     *
     * @param int $id
     * @param UpdatePersonajeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePersonajeRequest $request)
    {
        $personaje = $this->personajeRepository->find($id);

        if (empty($personaje)) {
            Flash::error('Personaje not found');

            return redirect(route('personajes.index'));
        }

        $personaje = $this->personajeRepository->update($request->all(), $id);

        Flash::success('Personaje updated successfully.');

        return redirect(route('personajes.index'));
    }

    /**
     * Remove the specified Personaje from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $personaje = $this->personajeRepository->find($id);

        if (empty($personaje)) {
            Flash::error('Personaje not found');

            return redirect(route('personajes.index'));
        }

        $this->personajeRepository->delete($id);

        Flash::success('Personaje deleted successfully.');

        return redirect(route('personajes.index'));
    }
}
