import { Link } from 'react-router-dom';
import logo from '/assets/logo-gite-blanc.png'; // chemin vers le logo

function Header() {
  return (
    <header className="bg-[#3DB2FF] py-4 px-6">
      <div className="flex justify-between items-center max-w-6xl mx-auto">
        {/* Logo cliquable */}
        <Link to="/">
          <img src={logo} alt="Gîte Pim Logo" className="w-24" />
        </Link>

        {/* Menu de navigation */}
        <nav className="space-x-6 text-white">
          <Link to="/" className="text-lg font-semibold hover:text-[#1e90ff]">
            Accueil
          </Link>
          <Link to="/reservation/recapitulatif" className="text-lg font-semibold hover:text-[#1e90ff]">
            Réservation
          </Link>
          <Link to="/repas" className="text-lg font-semibold hover:text-[#1e90ff]">
            Repas
          </Link>
          <Link to="/randonnee" className="text-lg font-semibold hover:text-[#1e90ff]">
            Randonnée
          </Link>
          <Link to="/kayak" className="text-lg font-semibold hover:text-[#1e90ff]">
            Kayak
          </Link>
          <Link to="/garderie" className="text-lg font-semibold hover:text-[#1e90ff]">
            Garderie
          </Link>
          <Link to="/bagne" className="text-lg font-semibold hover:text-[#1e90ff]">
            Bagne
          </Link>
        </nav>
      </div>
    </header>
  );
}

export default Header;
