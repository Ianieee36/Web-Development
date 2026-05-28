import { useEffect, useState } from 'react';

function AddressSearch({ value, onAddressSelect, placeholder }) {
  const [searchText, setSearchText] = useState(value || '');
  const [suggestions, setSuggestions] = useState([]);

  useEffect(() => {
    if (searchText.trim().length < 3) {
      setSuggestions([]);
      return;
    }

    const timer = setTimeout(async () => {
      const url =
        'https://nominatim.openstreetmap.org/search?' +
        new URLSearchParams({
          q: searchText,
          format: 'json',
          addressdetails: '1',
          limit: '5',
          countrycodes: 'nz',
        });

      try {
        const response = await fetch(url);
        const data = await response.json();
        setSuggestions(data);
      } catch (error) {
        console.error(error);
      }
    }, 600);

    return () => clearTimeout(timer);
  }, [searchText]);

  function handleSelect(place) {
    setSearchText(place.display_name);
    setSuggestions([]);
    // ← now passes back name AND coordinates
    onAddressSelect(place.display_name, parseFloat(place.lat), parseFloat(place.lon));
  }

  return (
    <div className="address-search">
      <input
        type="text"
        value={searchText}
        placeholder={placeholder}
        onChange={(event) => {
          setSearchText(event.target.value);
          onAddressSelect(event.target.value, null, null);
        }}
      />

      {suggestions.length > 0 && (
        <div className="address-suggestions">
          {suggestions.map((place) => (
            <button
              type="button"
              key={place.place_id}
              onClick={() => handleSelect(place)}
            >
              {place.display_name}
            </button>
          ))}
        </div>
      )}
    </div>
  );
}

export default AddressSearch;