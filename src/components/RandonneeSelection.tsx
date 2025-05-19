import { useState, useEffect } from 'react';

const chevauxDisponibles = [
  'Apache', 'Mustang', 'Sahara', 'Comète', 'Eclair', 'Paillettes', 'Koné', 'Confiture',
  'Foster', 'Inanouï', 'Prince', 'Buster', 'Charly', 'Sao', 'Tim', 'Tam', 'Nidguep', 'Papirus'
];

interface Props {
  personnes: number;
  onConfirm: (chevauxChoisis: string[]) => void;
}

export default function RandonneeSelection({ personnes, onConfirm }: Props) {
  const [selected, setSelected] = useState<string[]>([]);
  const [chevauxIndisponibles, setChevauxIndisponibles] = useState<string[]>([]);

  const date = localStorage.getItem('date') || '';
  const horaire = localStorage.getItem('horaire') || '';

  useEffect(() => {
    const reservations = JSON.parse(localStorage.getItem('reservations') || '[]');
    const usedChevaux = reservations
      .filter((r: any) => r.date === date && r.horaire === horaire && r.activity === 'randonnee')
      .flatMap((r: any) => r.chevaux || []);
    setChevauxIndisponibles(usedChevaux);
  }, [date, horaire]);

  const toggleSelection = (nom: string) => {
    if (chevauxIndisponibles.includes(nom)) return;
    if (selected.includes(nom)) {
      setSelected(selected.filter(c => c !== nom));
    } else {
      if (selected.length < personnes) {
        setSelected([...selected, nom]);
      }
    }
  };

  const handleConfirm = () => {
    if (selected.length === personnes) {
      onConfirm(selected);
    }
  };

  return (
    <div className="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">
      <h2 className="text-2xl font-bold text-center text-green-600">Choisissez vos chevaux 🐎</h2>

      <div className="grid grid-cols-2 sm:grid-cols-3 gap-4">
        {chevauxDisponibles.map(nom => {
          const isSelected = selected.includes(nom);
          const isUsed = chevauxIndisponibles.includes(nom);
          return (
          <div
  key={nom}
  onClick={() => toggleSelection(nom)}
  className={`cursor-pointer border rounded-lg p-3 text-center shadow-sm transition
    ${isUsed ? 'bg-gray-200 cursor-not-allowed opacity-60' : isSelected ? 'border-green-500 bg-green-50' : 'border-gray-300 hover:bg-gray-100'}`}
>
  <img
    src={`/assets/chevaux/${nom}.jpg`}
    alt={nom}
    className="w-full h-24 object-cover rounded mb-2"
  />
  <span className="font-medium">{nom}</span>
</div>

          );
        })}
      </div>

      <div className="text-center mt-4 font-medium text-gray-700">
        Chevaux sélectionnés : {selected.length} / {personnes}
      </div>

      <div className="text-center">
        <button
          onClick={handleConfirm}
          disabled={selected.length !== personnes}
          className={`mt-4 px-6 py-3 rounded-lg transition ${
            selected.length === personnes
              ? 'bg-green-600 hover:bg-green-700 text-white'
              : 'bg-gray-400 cursor-not-allowed text-white'
          }`}
        >
          Confirmer la sélection
        </button>
      </div>
    </div>
  );
}
