import { useNavigate } from 'react-router-dom';

const ChoixActivites = () => {
  const navigate = useNavigate();

  const activities = [
    { label: '🍽️ Repas', path: '/repas' },
    { label: '🐎 Randonnée à cheval', path: '/randonnee' },
    { label: '🛶 Sortie en kayak', path: '/kayak' },
    { label: '🧒 Garderie', path: '/garderie' },
    { label: '🏚️ Visite du bagne', path: '/bagne' },
    { label: '🛏️ Réserver une chambre', path: '/reservation' },
  ];

  return (
    <div className="max-w-3xl mx-auto py-10 px-6">
      <h1 className="text-3xl font-bold text-center text-blue-600 mb-8">
        Choisissez une activité à réserver
      </h1>

      <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
        {activities.map((act, index) => (
          <button
            key={index}
            onClick={() => navigate(act.path)}
            className="bg-white shadow p-6 rounded-lg text-lg font-semibold text-gray-800 hover:bg-blue-50 border border-gray-200"
          >
            {act.label}
          </button>
        ))}
      </div>
    </div>
  );
};

export default ChoixActivites;
