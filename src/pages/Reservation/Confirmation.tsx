import { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';

const Confirmation = () => {
  const [bungalow, setBungalow] = useState('');
  const [date, setDate] = useState('');
  const navigate = useNavigate();

  useEffect(() => {
    const selectedBungalow = localStorage.getItem('bungalow');
    const selectedDate = localStorage.getItem('date');
    if (!selectedBungalow || !selectedDate) {
      navigate('/reservation/bungalow');
    } else {
      setBungalow(selectedBungalow);
      setDate(selectedDate);
    }
  }, [navigate]);

  const handleConfirm = () => {
    navigate('/reservation/recapitulatif');
  };

  return (
    <div className="p-8 max-w-xl mx-auto text-center">
      <h1 className="text-3xl font-bold mb-6">🎉 Confirmation de votre réservation</h1>

      <div className="bg-white shadow p-6 rounded-lg text-left space-y-4">
        <p><strong>Bungalow choisi :</strong> {bungalow === 'mer' ? 'Vue Mer (2 personnes)' : 'Jardin (4 personnes)'}</p>
        <p><strong>Date sélectionnée :</strong> {date}</p>
      </div>

      <button
        onClick={handleConfirm}
        className="mt-6 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700"
      >
        Confirmer et continuer
      </button>
    </div>
  );
};

export default Confirmation;
