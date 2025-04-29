// 📁 src/components/RandonneeSelection.tsx
import { useState, useEffect } from 'react';
import chevalImages from '../data/chevalImages'; // { Apache: '/assets/apache.png', ... }

interface Props {
  cavaliers: number;
  onConfirm: (chevauxChoisis: string[]) => void;
}

export default function RandonneeSelection({ cavaliers, onConfirm }: Props) {
  const CHEVAUX = [
    'Apache', 'Mustang', 'Sahara', 'Comète', 'Eclair', 'Paillettes', 'Koné', 'Confiture',
    'Foster', 'Inanouï', 'Prince', 'Buster', 'Charly', 'Sao', 'Tim', 'Tam', 'Nidguep', 'Papirus'
  ];

  const [selected, setSelected] = useState<string[]>([]);

  const toggleSelection = (name: string) => {
    if (selected.includes(name)) {
      setSelected(selected.filter(c => c !== name));
    } else if (selected.length < cavaliers) {
      setSelected([...selected, name]);
    }
  };

  const handleConfirm = () => {
    if (selected.length === cavaliers) {
      onConfirm(selected);
    }
  };

  return (
    <div className="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow space-y-4">
      <h2 className="text-2xl font-bold text-center text-green-600 mb-4">Choisissez vos chevaux 🐴</h2>

      <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        {CHEVAUX.map(name => (
          <div
            key={name}
            className={`border-4 rounded-xl p-2 text-center cursor-pointer transition transform hover:scale-105
              ${selected.includes(name) ? 'border-green-500' : 'border-transparent'}`}
            onClick={() => toggleSelection(name)}
          >
            <img
              src={chevalImages[name] || '/assets/placeholder.png'}
              alt={name}
              className="w-full h-32 object-cover rounded-md"
            />
            <p className="mt-2 font-medium text-gray-700">{name}</p>
          </div>
        ))}
      </div>

      <div className="text-center mt-6">
        <p className="text-gray-600 font-semibold">
          Chevaux sélectionnés : {selected.length} / {cavaliers}
        </p>
        <button
          onClick={handleConfirm}
          disabled={selected.length !== cavaliers}
          className={`mt-4 px-6 py-3 rounded-lg transition font-semibold
            ${selected.length === cavaliers ? 'bg-green-600 text-white hover:bg-green-700' : 'bg-gray-400 cursor-not-allowed'}`}
        >
          Confirmer la sélection
        </button>
      </div>
    </div>
  );
}
