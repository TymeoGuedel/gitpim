import { useState } from 'react';

const carousels = {
  cheval: [
    '/assets/cheval1.png',
    '/assets/cheval2.png',
    '/assets/cheval3.png',
  ],
  repas: [
  
    '/assets/Famillesougroupes.png',
    '/assets/Détailromantique.png',
    '/assets/Zoomsurlesplats.png',
    '/assets/Leveroucoucherdusoleil.png',
  ],
  kayak: [
    '/assets/kayak1.png',
    '/assets/kayak2.png',
    '/assets/kayak3.png',
  ],
  garderie: [
    '/assets/garderie1.png',
    '/assets/garderie2.png',
    '/assets/garderie3.png',
  ],
  bagne: [
    '/assets/bagne1.png',
    '/assets/bagne2.png',
    '/assets/bagne3.png',
  ],
};

export default function Carousel({ activity }: { activity: keyof typeof carousels }) {
  const images = carousels[activity] ?? [];

  const [index, setIndex] = useState(0);

  const prev = () => setIndex((index - 1 + images.length) % images.length);
  const next = () => setIndex((index + 1) % images.length);

  return (
    <div className="relative max-w-3xl mx-auto mt-12 shadow-xl rounded-xl overflow-hidden">
      <img
        src={images[index]}
        alt={`${activity} ${index + 1}`}
        className="w-full h-[400px] object-cover transition-all duration-500"
      />

      <button
        onClick={prev}
        className="absolute top-1/2 left-2 transform -translate-y-1/2 bg-white/70 hover:bg-white px-3 py-1 rounded-full text-xl"
      >
        ‹
      </button>
      <button
        onClick={next}
        className="absolute top-1/2 right-2 transform -translate-y-1/2 bg-white/70 hover:bg-white px-3 py-1 rounded-full text-xl"
      >
        ›
      </button>

      <div className="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-2">
        {images.map((_, i) => (
          <div
            key={i}
            className={`w-3 h-3 rounded-full ${i === index ? 'bg-blue-500' : 'bg-gray-300'}`}
          />
        ))}
      </div>
    </div>
  );
}
