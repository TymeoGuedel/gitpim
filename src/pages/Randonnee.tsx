import ReservationLayout from '../components/ReservationLayout';

export default function Randonnee() {
  return (
    <ReservationLayout
      activity="randonnee"
      title="Randonnée à cheval"
      emoji="🐎"
      description="Explorez les sentiers à dos de cheval, accompagné·e d’un guide passionné."
      infoList={[
        '⏳ Durée : 1h30',
        '👥 Groupe de 8 personnes maximum',
        '🐴 16 chevaux disponibles + 2 pour les guides',
        '📅 Réservez pendant votre séjour'
      ]}
      image="/assets/cheval1.png"
      themeColor="#3DB2FF"
    />
  );
}