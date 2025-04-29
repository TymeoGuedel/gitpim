import { useLocation, useNavigate, Link } from 'react-router-dom';
import { useEffect } from 'react';

export default function Confirmation() {
  const location = useLocation();
  const navigate = useNavigate();
  const data = location.state;

  useEffect(() => {
    if (!data) {
      // Si pas de données, rediriger vers la page d'accueil automatiquement
      navigate('/');
    }
  }, [data, navigate]);

  if (!data) {
    return null; // Tu peux aussi afficher un loader ici si tu veux
  }

  return (
    <div className="min-h-screen flex items-center justify-center px-4 bg-[#F4F1EA]">
      <div className="bg-white p-8 rounded-xl shadow-lg max-w-xl w-full text-center">
        <h1 className="text-2xl font-bold text-green-600 mb-4">✅ Réservation Confirmée</h1>

        <div className="space-y-2 text-gray-700">
          <p><strong>Numéro :</strong> {data.num}</p>
          <p><strong>Date :</strong> {data.date}</p>
          {data.horaire && <p><strong>Horaire :</strong> {data.horaire}</p>}
          <p><strong>Nombre de personnes :</strong> {data.people}</p>

          {data.type && (
            <p><strong>Type :</strong> {data.type === 'mer' ? 'Bungalow Vue Mer' : 'Bungalow Jardin'}</p>
          )}

          {data.chevaux && (
            <div>
              <strong>Chevaux sélectionnés :</strong>
              <ul className="list-disc list-inside">
                {Array.isArray(data.chevaux) ? (
                  data.chevaux.map((c: string, i: number) => <li key={i}>{c}</li>)
                ) : (
                  <li>{data.chevaux}</li>
                )}
              </ul>
            </div>
          )}

          {data.kayaks && (
            <div>
              <strong>Kayaks sélectionnés :</strong>
              <ul className="list-disc list-inside">
                {Array.isArray(data.kayaks) ? (
                  data.kayaks.map((k: string, i: number) => <li key={i}>{k}</li>)
                ) : (
                  <li>{data.kayaks}</li>
                )}
              </ul>
            </div>
          )}
        </div>

        <Link to="/" className="mt-6 inline-block text-blue-600 hover:underline">
          Retour à l'accueil
        </Link>
      </div>
    </div>
  );
}
