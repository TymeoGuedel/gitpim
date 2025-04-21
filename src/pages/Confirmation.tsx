import { useLocation, Link } from 'react-router-dom';

export default function Confirmation() {
  const location = useLocation();
  const data = location.state;

  if (!data) {
    return (
      <div className="min-h-screen flex items-center justify-center text-center text-gray-600">
        <div>
          <h2 className="text-xl font-semibold mb-4">Aucune réservation trouvée</h2>
          <Link to="/" className="text-blue-600 hover:underline">Retour à l'accueil</Link>
        </div>
      </div>
    );
  }

  return (
    <div className="min-h-screen flex items-center justify-center px-4 bg-[#F4F1EA]">
      <div className="bg-white p-8 rounded-xl shadow-lg max-w-xl w-full text-center">
        <h1 className="text-2xl font-bold text-green-600 mb-4">✅ Réservation Confirmée</h1>
        <p className="text-gray-700 mb-2"><strong>Numéro :</strong> {data.num}</p>
        <p className="text-gray-700 mb-2"><strong>Date :</strong> {data.date}</p>
        <p className="text-gray-700 mb-2"><strong>Nombre de personnes :</strong> {data.people}</p>
        {data.type && <p className="text-gray-700 mb-2"><strong>Type :</strong> {data.type}</p>}
        {data.chevaux && (
          <p className="text-gray-700 mb-2 whitespace-pre-line">
            <strong>Chevaux attribués :</strong> {data.chevaux}
          </p>
        )}
        <Link to="/" className="mt-4 inline-block text-blue-600 hover:underline">Retour à l'accueil</Link>
      </div>
    </div>
  );
}
