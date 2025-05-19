import { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { genererNumeroReservation } from '../../utils/reservation.js';

const Confirmation = () => {
  const [bungalow, setBungalow] = useState('');
  const [dateArrivee, setDateArrivee] = useState('');
  const [dateDepart, setDateDepart] = useState('');
  const [personnes, setPersonnes] = useState('');
  const [numeroReservation, setNumeroReservation] = useState('');
  const navigate = useNavigate();

  useEffect(() => {
    const storedBungalow = localStorage.getItem('bungalow');
    const storedArrivee = localStorage.getItem('dateArrivee');
    const storedDepart = localStorage.getItem('dateDepart');
    const storedPersonnes = localStorage.getItem('personnes');
    const storedNumero = localStorage.getItem('numeroReservation');

    if (!storedBungalow || !storedArrivee || !storedDepart || !storedPersonnes) {
      navigate('/reservation');
    } else {
      setBungalow(storedBungalow);
      setDateArrivee(storedArrivee);
      setDateDepart(storedDepart);
      setPersonnes(storedPersonnes);

      if (storedNumero) {
        setNumeroReservation(storedNumero);
      } else {
        const nouveau = genererNumeroReservation('chambre');
        setNumeroReservation(nouveau);
        localStorage.setItem('numeroReservation', nouveau);
      }
    }
  }, [navigate]);

  const handleConfirm = () => {
    navigate('/reservation/recapitulatif');
  };

  return (
    <div className="p-8 max-w-xl mx-auto text-center">
      <h1 className="text-3xl font-bold mb-6">🎉 Confirmation de votre réservation</h1>

      <div className="bg-white shadow p-6 rounded-lg text-left space-y-4">
        <p><strong>Bungalow :</strong> {bungalow === 'mer' ? 'Vue Mer (2 pers max)' : 'Jardin (4 pers max)'}</p>
        <p><strong>Nombre de personnes :</strong> {personnes}</p>
        <p><strong>Date d’arrivée :</strong> {dateArrivee}</p>
        <p><strong>Date de départ :</strong> {dateDepart}</p>
        <p><strong>Numéro de réservation :</strong> <span className="font-mono text-blue-600">{numeroReservation}</span></p>
      </div>

      <button
        onClick={handleConfirm}
        className="mt-6 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700"
      >
        Confirmer et continuer
      </button>
    </div>
  );
};

export default Confirmation;
