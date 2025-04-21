// 📁 src/components/ReservationForm.tsx
import { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import Meteo from './Meteo';

type Props = {
  activity: 'chambre' | 'repas' | 'randonnee' | 'kayak' | 'garderie' | 'bagne';
  onConfirm?: (data: any) => void;
};

const CHEVAUX = [
  'Apache', 'Mustang', 'Sahara', 'Comète', 'Eclair', 'Paillettes', 'Koné', 'Confiture',
  'Foster', 'Inanouï', 'Prince', 'Buster', 'Charly', 'Sao', 'Tim', 'Tam', 'Nidguep', 'Papirus'
];

const ReservationForm = ({ activity, onConfirm }: Props) => {
  const [date, setDate] = useState('');
  const [type, setType] = useState('');
  const [people, setPeople] = useState(1);
  const [stock, setStock] = useState<any>({});
  const [arrival, setArrival] = useState('');
  const [departure, setDeparture] = useState('');

  const navigate = useNavigate();

  useEffect(() => {
    const savedStock = localStorage.getItem('stock');
    if (savedStock) {
      setStock(JSON.parse(savedStock));
    } else {
      const initial = {
        chambre: { mer: 10, jardin: 40 },
        repas: 30,
        randonnee: 16,
        kayak: { double: 6, simple: 2 },
        garderie: 15,
        bagne: 10,
      };
      setStock(initial);
      localStorage.setItem('stock', JSON.stringify(initial));
    }

    const a = localStorage.getItem('reservationArrivee');
    const d = localStorage.getItem('reservationDepart');
    if (a && d) {
      setArrival(a);
      setDeparture(d);
    }
  }, []);

  const updateStock = (updated: any) => {
    setStock(updated);
    localStorage.setItem('stock', JSON.stringify(updated));
  };

  const generateNumber = () => {
    const now = new Date();
    const yy = String(now.getFullYear()).slice(2);
    const mm = String(now.getMonth() + 1).padStart(2, '0');
    const prefix = {
      chambre: 'CH', repas: 'RE', randonnee: 'RA', kayak: 'KA', garderie: 'GA', bagne: 'BA'
    }[activity];
    const random = Math.floor(1000 + Math.random() * 9000);
    return `${prefix}${yy}${mm}${random}`;
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    const selectedDate = new Date(date);
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    if (selectedDate < today) {
      alert('❌ Date invalide (dans le passé)');
      return;
    }

    if (activity !== 'chambre') {
      const arrivalDate = new Date(arrival);
      const departureDate = new Date(departure);

      if (!arrival || !departure) {
        alert("❌ Vous devez avoir une réservation de bungalow pour accéder à cette activité.");
        return;
      }

      if (selectedDate < arrivalDate || selectedDate > departureDate) {
        alert("❌ La date de l'activité doit être comprise dans la période de votre séjour.");
        return;
      }
    }

    const updatedStock = { ...stock };

    if (activity === 'chambre') {
      const maxCap = type === 'mer' ? 2 : 4;
      const capacity = type === 'mer' ? updatedStock.chambre.mer : updatedStock.chambre.jardin;
      if (people > maxCap) {
        alert(`❌ Trop de personnes pour un bungalow ${type}. Max ${maxCap}`);
        return;
      }
      if (people > capacity) {
        alert('❌ Capacité insuffisante.');
        return;
      }
      if (type === 'mer') updatedStock.chambre.mer -= people;
      else updatedStock.chambre.jardin -= people;
    } else if (activity === 'repas') {
      if (people > updatedStock.repas) {
        alert('❌ Trop de couverts demandés. (Max 30 par créneau)');
        return;
      }
      updatedStock.repas -= people;
    } else if (activity === 'randonnee') {
      if (people > 8) {
        alert('❌ Groupe trop grand. Max 8 cavaliers par randonnée.');
        return;
      }
      if (people > updatedStock.randonnee) {
        alert('❌ Plus assez de chevaux disponibles.');
        return;
      }
      const chevauxAssignes = CHEVAUX.slice(0, people).join(', ');
      updatedStock.randonnee -= people;
      const num = generateNumber();
      updateStock(updatedStock);
      const reservation = { activity, date, people, chevaux: chevauxAssignes, num };
      const existing = JSON.parse(localStorage.getItem('reservations') || '[]');
      localStorage.setItem('reservations', JSON.stringify([...existing, reservation]));
      
      navigate('/confirmation', { state: reservation });
      
      return;
    } else if (activity === 'kayak') {
      const total = updatedStock.kayak.double + updatedStock.kayak.simple;
      if (people > 8 || people > total) {
        alert('❌ Trop de personnes pour le kayak. Max 8.');
        return;
      }
      updatedStock.kayak.double = Math.max(0, updatedStock.kayak.double - Math.min(people, updatedStock.kayak.double));
      updatedStock.kayak.simple = Math.max(0, updatedStock.kayak.simple - Math.max(0, people - updatedStock.kayak.double));
    } else if (activity === 'garderie') {
      if (people > updatedStock.garderie) {
        alert('❌ La garderie est complète. Max 15 enfants.');
        return;
      }
      updatedStock.garderie -= people;
    } else if (activity === 'bagne') {
      if (people > updatedStock.bagne) {
        alert('❌ Trop de visiteurs. Max 10 par session.');
        return;
      }
      updatedStock.bagne -= people;
    }

    updateStock(updatedStock);
    const num = generateNumber();
    const reservation = { activity, date, people, type, num };
    const existing = JSON.parse(localStorage.getItem('reservations') || '[]');
    localStorage.setItem('reservations', JSON.stringify([...existing, reservation]));
    
    navigate('/confirmation', { state: reservation });
    
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
          className="border p-2 w-full mt-1"
        />
        {date && <Meteo date={date} />}
      </label>

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

      <button type="submit" className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Réserver
      </button>
    </form>
  );
};

export default ReservationForm;
