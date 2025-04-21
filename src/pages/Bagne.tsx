import ReservationLayout from '../components/ReservationLayout';

export default function Bagne() {
  return (
    <ReservationLayout
      activity="bagne"
      title="Visite du Bagne"
      emoji="🏛️"
      description="Remontez le temps et découvrez l'histoire poignante du bagne de l'île."
      infoList={[
        '⏱️ Durée : 90 minutes',
        '👥 Jusqu’à 10 visiteurs par session',
        '🗺️ Visite guidée par un expert local',
        '📷 Prises de vues autorisées'
      ]}
      image="/assets/bagne1.png"
      themeColor="#374151"
    />
  );
}
