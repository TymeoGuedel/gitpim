import { useState } from 'react';
import { useNavigate } from 'react-router-dom';

const ChoixBungalow = () => {
  const [selection, setSelection] = useState<'mer' | 'jardin' | null>(null);
  const navigate = useNavigate();

  const handleSuivant = () => {
    if (selection) {
        navigate('/reservation/date', { state: { bungalow: selection } });

    }
  };

  return (
    <div className="max-w-4xl mx-auto px-4 py-10">
      <h1 className="text-3xl font-bold text-center text-[#3DB2FF] mb-8">Choisissez votre Bungalow</h1>

      <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div
          onClick={() => setSelection('mer')}
          className={`cursor-pointer rounded-2xl border-4 p-4 shadow-xl transition hover:scale-105 duration-200 ${
            selection === 'mer' ? 'border-blue-500' : 'border-transparent'
          }`}
        >
          <img src="/assets/bungalow-mer.png" alt="Bungalow Vue Mer" className="rounded-lg mb-4 w-full h-52 object-cover" />
          <h2 className="text-xl font-semibold">Bungalow Vue Mer</h2>
          <p className="text-gray-600 text-sm mt-2">Pour 2 personnes, vue sur le lagon, parfait pour les couples.</p>
        </div>

        <div
          onClick={() => setSelection('jardin')}
          className={`cursor-pointer rounded-2xl border-4 p-4 shadow-xl transition hover:scale-105 duration-200 ${
            selection === 'jardin' ? 'border-blue-500' : 'border-transparent'
          }`}
        >
          <img src="/assets/bungalow-jardin.png" alt="Bungalow Jardin" className="rounded-lg mb-4 w-full h-52 object-cover" />
          <h2 className="text-xl font-semibold">Bungalow Jardin</h2>
          <p className="text-gray-600 text-sm mt-2">Pour 4 personnes, idéal pour les familles ou groupes d’amis.</p>
        </div>
      </div>

      <div className="text-center mt-10">
        <button
          disabled={!selection}
          onClick={handleSuivant}
          className={`px-6 py-3 text-white font-semibold rounded-lg transition ${
            selection ? 'bg-[#3DB2FF] hover:bg-blue-600' : 'bg-gray-400 cursor-not-allowed'
          }`}
        >
          Suivant
        </button>
      </div>
    </div>
  );
};

export default ChoixBungalow;
