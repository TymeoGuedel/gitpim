import { Routes, Route } from 'react-router-dom';
import Accueil from './pages/Accueil';
import Chambre from './pages/Chambre';
import Repas from './pages/Repas';
import Randonnee from './pages/Randonnee';
import Kayak from './pages/Kayak';
import Garderie from './pages/Garderie';
import Bagne from './pages/Bagne';
import Confirmation from './pages/Confirmation';
import Header from './components/Header';
import Footer from './components/Footer';
import ChoixBungalow from './pages/Reservation/ChoixBungalow';
import ChoixDates from './pages/Reservation/ChoixDates';
import Recapitulatif from './pages/Reservation/Recapitulatif';





function App() {
  return (
    <div className="min-h-screen flex flex-col bg-[#F4F1EA]">
      <Header />
      <main className="flex-1">
        <Routes>
          <Route path="/" element={<Accueil />} />
          <Route path="/chambre" element={<Chambre />} />
          <Route path="/repas" element={<Repas />} />
          <Route path="/randonnee" element={<Randonnee />} />
          <Route path="/kayak" element={<Kayak />} />
          <Route path="/garderie" element={<Garderie />} />
          <Route path="/reservation/choix-bungalow" element={<ChoixBungalow />} />
          <Route path="/bagne" element={<Bagne />} />
          <Route path="/confirmation" element={<Confirmation />} />
          <Route path="/reservation/date" element={<ChoixDates />} />
          <Route path="/reservation/recapitulatif" element={<Recapitulatif />} />
        </Routes>
      </main>
      <Footer />
    </div>
  );
}

export default App;