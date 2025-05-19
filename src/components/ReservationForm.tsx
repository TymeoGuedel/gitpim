import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import Meteo from './Meteo';
import KayakSelection from './KayakSelection';
import RandonneeSelection from './RandonneeSelection';

interface Props {
  activity: 'chambre' | 'repas' | 'randonnee' | 'kayak' | 'garderie' | 'bagne';
}

const generateReservationNumber = (activity: string) => {
  const prefixes: Record<string, string> = {
    chambre: 'CH',
    repas: 'RE',
    randonnee: 'RA',
    kayak: 'KA',
    garderie: 'GA',
    bagne: 'BA',
  };
  const prefix = prefixes[activity] || 'XX';
  const now = new Date();
  const year = now.getFullYear().toString().slice(2);
  const month = (now.getMonth() + 1).toString().padStart(2, '0');
  const base = `${prefix}${year}${month}`;

  const existing = JSON.parse(localStorage.getItem('reservations') || '[]');
  const count = existing.filter((r: any) => r.activity === activity).length + 1;
  const number = String(count).padStart(4, '0');
  return base + number;
};

export default function ReservationForm({ activity }: Props) {
  const [date, setDate] = useState('');
  const [horaire, setHoraire] = useState('');
  const [people, setPeople] = useState(1);
  const [type, setType] = useState('');
  const [selectedKayaks, setSelectedKayaks] = useState<string[]>([]);
  const [selectedChevaux, setSelectedChevaux] = useState<string[]>([]);
  const [error, setError] = useState('');

  const dateArrivee = localStorage.getItem('dateArrivee');
  const dateDepart = localStorage.getItem('dateDepart');
  const navigate = useNavigate();

 const getHorairesDisponibles = () => {
  switch (activity) {
    case 'repas':
      return ['11:00', '12:00', '13:00', '18:00', '19:00', '20:00'];
    case 'randonnee':
    case 'kayak':
    case 'bagne': {
      const slots = [];
      for (let h = 8; h <= 16; h += 2) {
        const start = String(h).padStart(2, '0') + ':00';
        const end = String(h + 1) + ':30';
        slots.push(`${start} - ${end}`);
      }
      return slots;
    }
    case 'garderie':
      return ['Matin', 'Après-midi', 'Journée complète'];
    default:
      return [];
  }
};


  const getMaxPlaces = () => {
    switch (activity) {
      case 'repas': return 30;
      case 'randonnee': return 8;
      case 'kayak': return 8;
      case 'garderie': return 15;
      case 'bagne': return 10;
      default: return Infinity;
    }
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();

    if (!date || !horaire || people <= 0) {
      setError("Veuillez remplir tous les champs.");
      return;
    }

    if (!dateArrivee || !dateDepart || date < dateArrivee || date >= dateDepart) {
      setError("La date doit être comprise dans la durée de votre séjour.");
      return;
    }

    const existing = JSON.parse(localStorage.getItem('reservations') || '[]');
    const filtered = existing.filter((r: any) => r.date === date && r.horaire === horaire && r.activity === activity);
    const totalPeople = filtered.reduce((sum: number, r: any) => sum + (r.people || 0), 0);

    if (totalPeople + people > getMaxPlaces()) {
      setError("Ce créneau est déjà complet. Veuillez en choisir un autre.");
      return;
    }

    const numero = generateReservationNumber(activity);

    const reservation = {
      numero,
      date,
      horaire,
      people,
      activity,
      type,
      kayaks: selectedKayaks,
      chevaux: selectedChevaux
    };

    localStorage.setItem('reservations', JSON.stringify([...existing, reservation]));

    setError('');
    navigate('/reservation/confirmation', { state: reservation });
  };

  return (
    <form onSubmit={handleSubmit} className="space-y-4 max-w-md mx-auto">
      <label className="block">
        Date :
        <input
          type="date"
          required
          value={date}
          onChange={(e) => setDate(e.target.value)}
          min={dateArrivee || ""}
          max={dateDepart || ""}
          className="border p-2 w-full mt-1"
        />
        {date && <Meteo date={date} />}
      </label>

      {getHorairesDisponibles().length > 0 && (
        <label className="block">
          Horaire :
          <select
            value={horaire}
            onChange={(e) => setHoraire(e.target.value)}
            className="border p-2 w-full mt-1"
          >
            <option value="">-- Choisir un horaire --</option>
            {getHorairesDisponibles().map(h => (
              <option key={h} value={h}>{h}</option>
            ))}
          </select>
        </label>
      )}

      {activity === 'chambre' && (
        <label className="block">
          Type :
          <select
            value={type}
            onChange={(e) => setType(e.target.value)}
            required
            className="border p-2 w-full mt-1"
          >
            <option value="">-- Choisir --</option>
            <option value="mer">Bungalow Mer (2p)</option>
            <option value="jardin">Bungalow Jardin (4p)</option>
          </select>
        </label>
      )}

      <label className="block">
        Nombre de personnes :
        <input
          type="number"
          min={1}
          value={people}
          onChange={(e) => setPeople(Number(e.target.value))}
          className="border p-2 w-full mt-1"
        />
      </label>

      {activity === 'kayak' && (
        <KayakSelection personnes={people} onConfirm={setSelectedKayaks} />
      )}

      {activity === 'randonnee' && (
        <RandonneeSelection personnes={people} onConfirm={setSelectedChevaux} />
      )}

      {error && <p className="text-red-600">{error}</p>}

      <button
        type="submit"
        className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
      >
        Réserver
      </button>
    </form>
  );
}
