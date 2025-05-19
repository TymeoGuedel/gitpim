const compteurReservations = {
  CH: 0,
  RE: 0,
  RA: 0,
  KA: 0,
  GA: 0,
  BA: 0
};

function genererNumeroReservation(type) {
  const prefixes = {
    chambre: 'CH',
    repas: 'RE',
    randonnee: 'RA',
    kayak: 'KA',
    garderie: 'GA',
    bagne: 'BA'
  };

  const now = new Date();
  const annee = String(now.getFullYear()).slice(2);
  const mois = String(now.getMonth() + 1).padStart(2, '0');

  const prefixe = prefixes[type];
  if (!prefixe) throw new Error("Type de réservation invalide");

  compteurReservations[prefixe]++;
  const numero = String(compteurReservations[prefixe]).padStart(4, '0');

  return `${prefixe}${annee}${mois}${numero}`;
}

// Exporter pour utilisation ailleurs
export { genererNumeroReservation };
