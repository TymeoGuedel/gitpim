import { Link } from 'react-router-dom';

export default function Footer() {
  const resetStock = () => {
    localStorage.removeItem('stock');
    localStorage.removeItem('reservations');
    alert("Stock et réservations réinitialisés !");
    window.location.reload();
  };

  return (
    <footer className="bg-[#1E3A8A] text-white py-8 px-4 md:px-16 mt-16">
      <div className="max-w-6xl mx-auto grid md:grid-cols-3 gap-8">
        {/* Logo + Description */}
        <div>
          <h2 className="text-xl font-bold mb-2">Gîte Pim 🌴</h2>
          <p className="text-sm text-gray-200">
            Séjournez au cœur de la nature, entre mer et forêt. Une expérience unique en Nouvelle-Calédonie.
          </p>
        </div>

        {/* Liens */}
        <div>
          <h3 className="font-semibold mb-2">Navigation</h3>
          <ul className="space-y-1 text-sm">
            <li><Link to="/" className="hover:underline">Accueil</Link></li>
            <li><Link to="/chambre" className="hover:underline">Chambres</Link></li>
            <li><Link to="/repas" className="hover:underline">Repas</Link></li>
            <li><Link to="/randonnee" className="hover:underline">Randonnée</Link></li>
            <li><Link to="/kayak" className="hover:underline">Kayak</Link></li>
            <li><Link to="/garderie" className="hover:underline">Garderie</Link></li>
            <li><Link to="/bagne" className="hover:underline">Bagne</Link></li>
          </ul>

          {/* Bouton Réinitialisation */}
          <div className="mt-4">
            <button
              onClick={resetStock}
              className="text-xs text-yellow-300 underline hover:text-yellow-100"
            >
              🔄 Réinitialiser les stocks (dev)
            </button>
          </div>
        </div>

        {/* Contact */}
        <div>
          <h3 className="font-semibold mb-2">Contact</h3>
          <p className="text-sm">📍 Île de Pam, Poum</p>
          <p className="text-sm">📞 +687 99 99 99</p>
          <p className="text-sm">✉️ contact@gitepim.nc</p>
        </div>
      </div>

      <div className="mt-10 text-center text-xs text-gray-300">
        © {new Date().getFullYear()} Gîte Pim. Tous droits réservés.
      </div>
    </footer>
  );
}
