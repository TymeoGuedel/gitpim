import { useState } from 'react';
import { useNavigate } from 'react-router-dom';

export default function ChoixDates() {
  const [arrivalDate, setArrivalDate] = useState('');
  const [departureDate, setDepartureDate] = useState('');
  const [people, setPeople] = useState(1);
  const [error, setError] = useState('');
  const navigate = useNavigate();

  const handleNext = () => {
    const arrival = new Date(arrivalDate);
    const departure = new Date(departureDate);
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    if (!arrivalDate || !departureDate || arrival < today || departure <= arrival) {
      setError("Veuillez choisir des dates valides (arrivée future et départ après l'arrivée).");
      return;
    }

    localStorage.setItem('reservationArrivee', arrivalDate);
    localStorage.setItem('reservationDepart', departureDate);
    localStorage.setItem('reservationPeople', people.toString());
    navigate('/reservation/recapitulatif');
  };

  return (
    <div className="max-w-md mx-auto p-6">
      <h2 className="text-2xl font-bold text-center mb-6">Choisissez vos dates de séjour</h2>

      <label className="block mb-4">
        Date d'arrivée :
        <input
          type="date"
          value={arrivalDate}
          onChange={(e) => setArrivalDate(e.target.value)}
          className="border mt-1 p-2 w-full"
        />
      </label>

      <label className="block mb-4">
        Date de départ :
        <input
          type="date"
          value={departureDate}
          onChange={(e) => setDepartureDate(e.target.value)}
          className="border mt-1 p-2 w-full"
        />
      </label>

      <label className="block mb-6">
        Nombre de personnes :
        <input
          type="number"
          value={people}
          min={1}
          onChange={(e) => setPeople(Number(e.target.value))}
          className="border mt-1 p-2 w-full"
        />
      </label>

      {error && <p className="text-red-500 mb-4 text-sm">{error}</p>}

      <button
        onClick={handleNext}
        className="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded w-full"
      >
        Suivant
      </button>
    </div>
  );
}
