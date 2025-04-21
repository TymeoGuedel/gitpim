import GarderieSection from '../components/GarderieSection';
import ChambresSection from '../components/ChambresSection';
import PrestationsSection from '../components/PrestationsSection';
import InfosSection from '../components/InfosSection';
import { Link } from 'react-router-dom';

function Accueil() {
  return (
    <div className="text-center">
      {/* Hero Section */}
      <section
  className="bg-cover bg-center text-white py-32 px-4 text-center"
  style={{ backgroundImage: "url('/assets/fond.png')" }} // mets le vrai nom de ton image ici
>
  <div className="bg-black bg-opacity-40 p-6 rounded-xl inline-block">
    <h1 className="text-4xl md:text-5xl font-bold text-[#3DB2FF] mb-4 drop-shadow-lg">
      Bienvenue au Gîte Pim 🌴
    </h1>
    <p className="text-lg drop-shadow mb-6">
      Découvrez nos bungalows, activités en pleine nature, et un cadre idyllique pour toute la famille.
    </p>
    <Link to="/reservation/choix-bungalow">
      <button className="bg-[#3DB2FF] hover:bg-blue-600 text-white px-6 py-3 rounded-xl transition shadow">
        Réserver maintenant
      </button>
    </Link>
  </div>
</section>

{/* Section Activités & Prestations */}
<PrestationsSection />

{/* Section Chambres (réservation bungalow) */}
<ChambresSection />

{/* Section Garderie (affichage sans bouton) */}
<GarderieSection />

{/* Infos pratiques */}
<InfosSection />

    </div>
  );
}

export default Accueil;