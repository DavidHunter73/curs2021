<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRopaRequest;
use App\Http\Requests\UpdateRopaRequest;
use App\Repositories\RopaRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class RopaController extends AppBaseController
{
    /** @var  RopaRepository */
    private $ropaRepository;

    public function __construct(RopaRepository $ropaRepo)
    {
        $this->ropaRepository = $ropaRepo;
    }

    /**
     * Display a listing of the Ropa.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $ropas = $this->ropaRepository->all();

        return view('ropas.index')
            ->with('ropas', $ropas);
    }

    /**
     * Show the form for creating a new Ropa.
     *
     * @return Response
     */
    public function create()
    {
        return view('ropas.create');
    }

    /**
     * Store a newly created Ropa in storage.
     *
     * @param CreateRopaRequest $request
     *
     * @return Response
     */
    public function store(CreateRopaRequest $request)
    {
        $input = $request->all();

        $ropa = $this->ropaRepository->create($input);

        Flash::success('Ropa saved successfully.');

        return redirect(route('ropas.index'));
    }

    /**
     * Display the specified Ropa.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $ropa = $this->ropaRepository->find($id);

        if (empty($ropa)) {
            Flash::error('Ropa not found');

            return redirect(route('ropas.index'));
        }

        return view('ropas.show')->with('ropa', $ropa);
    }

    /**
     * Show the form for editing the specified Ropa.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $ropa = $this->ropaRepository->find($id);

        if (empty($ropa)) {
            Flash::error('Ropa not found');

            return redirect(route('ropas.index'));
        }

        return view('ropas.edit')->with('ropa', $ropa);
    }

    /**
     * Update the specified Ropa in storage.
     *
     * @param int $id
     * @param UpdateRopaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRopaRequest $request)
    {
        $ropa = $this->ropaRepository->find($id);

        if (empty($ropa)) {
            Flash::error('Ropa not found');

            return redirect(route('ropas.index'));
        }

        $ropa = $this->ropaRepository->update($request->all(), $id);

        Flash::success('Ropa updated successfully.');

        return redirect(route('ropas.index'));
    }

    /**
     * Remove the specified Ropa from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $ropa = $this->ropaRepository->find($id);

        if (empty($ropa)) {
            Flash::error('Ropa not found');

            return redirect(route('ropas.index'));
        }

        $this->ropaRepository->delete($id);

        Flash::success('Ropa deleted successfully.');

        return redirect(route('ropas.index'));
    }
}
