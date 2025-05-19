import { useState } from 'react';
import { useNavigate } from 'react-router-dom';

const ChoixReservation = () => {
  const [personnes, setPersonnes] = useState(1);
  const [bungalow, setBungalow] = useState('');
  const [dateArrivee, setDateArrivee] = useState('');
  const [dateDepart, setDateDepart] = useState('');
  const [erreur, setErreur] = useState('');
  const navigate = useNavigate();

  const today = new Date().toISOString().split("T")[0];

  const handleSubmit = (e) => {
    e.preventDefault();

    if (!bungalow || !dateArrivee || !dateDepart) {
      setErreur("Veuillez remplir tous les champs.");
      return;
    }

    if (dateDepart <= dateArrivee) {
      setErreur("La date de départ doit être après la date d’arrivée.");
      return;
    }

    localStorage.setItem('personnes', String(personnes));
    localStorage.setItem('bungalow', bungalow);
    localStorage.setItem('dateArrivee', dateArrivee);
    localStorage.setItem('dateDepart', dateDepart);

    navigate('/reservation/confirmation');
  };

  const bungalowOptions = {
    mer: personnes <= 2,
    jardin: personnes >= 3 && personnes <= 4
  };

  return (
    <div className="p-8 max-w-xl mx-auto">
      <h1 className="text-3xl font-bold mb-6 text-center">Réservez votre bungalow</h1>

      <form onSubmit={handleSubmit} className="space-y-6 bg-white shadow-md rounded-lg p-6">
        <div>
          <label className="block font-semibold mb-2">Nombre de personnes :</label>
          <select
            value={personnes}
            onChange={(e) => {
              const newVal = parseInt(e.target.value);
              setPersonnes(newVal);
              if (newVal <= 2 && bungalow === 'jardin') setBungalow('');
              if (newVal >= 3 && bungalow === 'mer') setBungalow('');
            }}
            className="border px-4 py-2 rounded w-full"
          >
            {[1, 2, 3, 4].map((n) => (
              <option key={n} value={n}>{n}</option>
            ))}
          </select>
        </div>

        <div>
          <label className="block font-semibold mb-2">Type de bungalow :</label>
          <div className="space-y-2">
            <label className={`flex items-center space-x-2 ${!bungalowOptions.mer && 'opacity-50'}`}>
              <input
                type="radio"
                value="mer"
                checked={bungalow === 'mer'}
                onChange={(e) => setBungalow(e.target.value)}
                disabled={!bungalowOptions.mer}
              />
              <span>Vue Mer (2 personnes max)</span>
            </label>
            <label className={`flex items-center space-x-2 ${!bungalowOptions.jardin && 'opacity-50'}`}>
              <input
                type="radio"
                value="jardin"
                checked={bungalow === 'jardin'}
                onChange={(e) => setBungalow(e.target.value)}
                disabled={!bungalowOptions.jardin}
              />
              <span>Vue Jardin (3 à 4 personnes)</span>
            </label>
          </div>
        </div>

        <div>
          <label className="block font-semibold mb-2">Date d’arrivée :</label>
          <input
            type="date"
            value={dateArrivee}
            onChange={(e) => {
              setDateArrivee(e.target.value);
              if (dateDepart && e.target.value >= dateDepart) {
                setDateDepart('');
              }
            }}
            min={today}
            className="border px-4 py-2 rounded w-full"
          />
        </div>

        <div>
          <label className="block font-semibold mb-2">Date de départ :</label>
          <input
            type="date"
            value={dateDepart}
            onChange={(e) => setDateDepart(e.target.value)}
            min={dateArrivee || today}
            className="border px-4 py-2 rounded w-full"
          />
        </div>

        {erreur && <p className="text-red-600">{erreur}</p>}

        <button
          type="submit"
          className="w-full bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700"
        >
          Confirmer ma réservation
        </button>
      </form>
    </div>
  );
};

export default ChoixReservation;
