<?php

namespace App\Controllers;

use App\Models\User_model;
use App\Models\ReservationModel;
use CodeIgniter\Controller;

class Reservation extends Controller
{
    public function index()
    {
        helper('url');
        
        // Récupérer l'ID de l'utilisateur connecté
        $userId = session()->get('user')['id'];

        // Créer une instance du modèle User_model
        $userModel = new User_model();

        // Récupérer les informations de l'utilisateur connecté
        $user = $userModel->find($userId);

        if (!$user) {
            // L'utilisateur n'existe pas, vous pouvez gérer cela selon vos besoins
            return redirect()->to('/login')->with('error', 'Utilisateur non trouvé.');
        }

        // Créer une instance du modèle ReservationModel
        $reservationModel = new ReservationModel();

        // Récupérer les réservations de l'utilisateur connecté
        $data['reservations'] = $reservationModel->where('user_id', $userId)->findAll();

        // Charger la vue en passant les données
        echo view('reservation', $data);
    }

    public function traiterReservation()
    {
        // Récupérer l'ID de l'utilisateur connecté
        $userId = session()->get('user')['id'];

        // Récupérer les données du formulaire
        $dateReservation = $this->request->getPost('dateReservation');
        $datefinReservation = $this->request->getPost('datefinReservation');
        $chambre = $this->request->getPost('chambre');

        // Créer une instance du modèle ReservationModel
        $reservationModel = new ReservationModel();

        // Insérer la réservation liée à l'utilisateur connecté
        $reservationModel->insert([
            'Date_de_Demande' => $dateReservation,
            'Date_de_fin' => $datefinReservation,
            'Chambre' => $chambre,
            'user_id' => $userId
        ]);

        // Rediriger vers la page de réservation après l'insertion réussie
        return redirect()->to(site_url('reservation'))->setStatusCode(302);
    }
}
