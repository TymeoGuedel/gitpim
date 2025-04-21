// Exemple pour Garderie.tsx
import ReservationLayout from '../components/ReservationLayout';

export default function Garderie() {
  return (
    <ReservationLayout
      activity="garderie"
      title="Garderie Enfants"
      emoji="👶"
      description="Confiez vos enfants à notre équipe professionnelle pendant que vous explorez l'île."
      infoList={[
        '🧸 Accueil d’enfants de 3 à 10 ans',
        '👩‍🏫 Encadrement qualifié',
        '🎨 Activités, jeux, lectures',
        '👶 Capacité : 15 enfants max/session'
      ]}
      image="/assets/garderie1.png"
      themeColor="#EC4899"
    />
  );
}
