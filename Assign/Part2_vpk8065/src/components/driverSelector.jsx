function DriverSelector({ selectedDriver, onDriverChange }) {
  const drivers = [
    { id: 'D001', name: 'John Smith' },
    { id: 'D002', name: 'Maria Santos' },
    { id: 'D003', name: 'Alex Tan' },
    { id: 'D004', name: 'Sarah Lee' },
  ];

  return (
    <div>
      <label>Select Driver</label>
      <select
        value={selectedDriver}
        onChange={(e) => onDriverChange(e.target.value)}
      >
        <option value="">-- Choose a driver --</option>
        {drivers.map((driver) => (
          <option key={driver.id} value={driver.id}>
            {driver.id} — {driver.name}
          </option>
        ))}
      </select>
    </div>
  );
}

export default DriverSelector;
