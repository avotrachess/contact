<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

interface ControllerInterface
{
    /**
     * Methode pour page d'accueil
     */
    public function index();

    /**
     * Methode pour page de creation
     */
    public function add(Request $request);

    /**
     * Methode pour page de modification
     */
    public function edit(Request $request, int $id);

    /**
     * Methode pour page de suppression
     */
    public function delete();

    /**
     * @param array $data
     *
     * @return array
     */
    public function sanitize(array $data = []): array;
}