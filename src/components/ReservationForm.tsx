// 📁 src/components/ReservationForm.tsx
import { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import Meteo from './Meteo';
import KayakSelection from './KayakSelection';
import RandonneeSelection from './RandonneeSelection';

const CHEVAUX = [
  'Apache', 'Mustang', 'Sahara', 'Comète', 'Eclair', 'Paillettes', 'Koné', 'Confiture',
  'Foster', 'Inanouï', 'Prince', 'Buster', 'Charly', 'Sao', 'Tim', 'Tam', 'Nidguep', 'Papirus'
];

const horairesDisponibles = ['Matin', 'Après-midi'];

interface Props {
  activity: 'chambre' | 'repas' | 'randonnee' | 'kayak' | 'garderie' | 'bagne';
}

export default function ReservationForm({ activity }: Props) {
  const [date, setDate] = useState('');
  const [horaire, setHoraire] = useState('Matin');
  const [people, setPeople] = useState(1);
  const [type, setType] = useState('');
  const [selectedKayaks, setSelectedKayaks] = useState<string[]>([]);
  const [selectedChevaux, setSelectedChevaux] = useState<string[]>([]);

  const navigate = useNavigate();

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    const reservation = { date, horaire, people, activity, type, kayaks: selectedKayaks, chevaux: selectedChevaux };
    const existing = JSON.parse(localStorage.getItem('reservations') || '[]');
    localStorage.setItem('reservations', JSON.stringify([...existing, reservation]));
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
          className="border p-2 w-full mt-1"
        />
        {date && <Meteo date={date} />}
      </label>

      <label className="block">
        Horaire :
        <select
          value={horaire}
          onChange={(e) => setHoraire(e.target.value)}
          className="border p-2 w-full mt-1"
        >
          {horairesDisponibles.map(h => <option key={h} value={h}>{h}</option>)}
        </select>
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

      {activity === 'kayak' && (
        <KayakSelection personnes={people} onConfirm={setSelectedKayaks} />
      )}

      {activity === 'randonnee' && (
        <RandonneeSelection personnes={people} onConfirm={setSelectedChevaux} />
      )}

      <button
        type="submit"
        className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
      >
        Réserver
      </button>
    </form>
  );
}
