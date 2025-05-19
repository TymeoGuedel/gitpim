import { useState, useEffect } from 'react';

const kayaksDisponibles = [
  { id: 'Double 1', type: 'double', places: 2 },
  { id: 'Double 2', type: 'double', places: 2 },
  { id: 'Double 3', type: 'double', places: 2 },
  { id: 'Simple 1', type: 'simple', places: 1 },
  { id: 'Simple 2', type: 'simple', places: 1 },
];

interface Props {
  personnes: number;
  onConfirm: (kayaksChoisis: string[]) => void;
}

export default function KayakSelection({ personnes, onConfirm }: Props) {
  const [selected, setSelected] = useState<string[]>([]);
  const [totalPlaces, setTotalPlaces] = useState(0);
  const [kayaksIndisponibles, setKayaksIndisponibles] = useState<string[]>([]);

  const date = localStorage.getItem('date') || '';
  const horaire = localStorage.getItem('horaire') || '';

  useEffect(() => {
    const reservations = JSON.parse(localStorage.getItem('reservations') || '[]');
    const usedKayaks = reservations
      .filter((r: any) => r.date === date && r.horaire === horaire && r.activity === 'kayak')
      .flatMap((r: any) => r.kayaks || []);
    setKayaksIndisponibles(usedKayaks);
  }, [date, horaire]);

  useEffect(() => {
    const total = selected
      .map(id => kayaksDisponibles.find(k => k.id === id)?.places || 0)
      .reduce((a, b) => a + b, 0);
    setTotalPlaces(total);
  }, [selected]);

  const toggleSelection = (id: string) => {
    if (kayaksIndisponibles.includes(id)) return;
    if (selected.includes(id)) {
      setSelected(selected.filter(k => k !== id));
    } else {
      setSelected([...selected, id]);
    }
  };

  const handleConfirm = () => {
    if (totalPlaces === personnes) {
      onConfirm(selected);
    }
  };

  return (
    <div className="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">
      <h2 className="text-2xl font-bold text-center text-blue-600">Choisissez vos kayaks 🚣</h2>

      <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
        {kayaksDisponibles.map(k => {
          const isSelected = selected.includes(k.id);
          const isUsed = kayaksIndisponibles.includes(k.id);
          return (
            <div
              key={k.id}
              onClick={() => toggleSelection(k.id)}
              className={`cursor-pointer border rounded-lg p-4 flex items-center justify-between shadow-sm transition
                ${isUsed ? 'bg-gray-200 cursor-not-allowed opacity-60' : isSelected ? 'border-blue-500 bg-blue-50' : 'border-gray-300 hover:bg-gray-100'}`}
            >
              <div className="text-lg">
                {k.type === 'double' ? '🚣 Kayak Double' : '🛶 Kayak Simple'} — {k.id}
              </div>
              <div className="text-sm text-gray-600">{k.places} place(s)</div>
            </div>
          );
        })}
      </div>

      <div className="text-center mt-4 font-medium text-gray-700">
        Places sélectionnées : {totalPlaces} / {personnes}
      </div>

      <div className="text-center">
        <button
          onClick={handleConfirm}
          disabled={totalPlaces !== personnes}
          className={`mt-4 px-6 py-3 rounded-lg transition ${
            totalPlaces === personnes
              ? 'bg-blue-600 hover:bg-blue-700 text-white'
              : 'bg-gray-400 cursor-not-allowed text-white'
          }`}
        >
          Confirmer la sélection
        </button>
      </div>
    </div>
  );
}
