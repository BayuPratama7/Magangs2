-- Create Provinsi Table
CREATE TABLE IF NOT EXISTS provinsi (
    provinsi_id SERIAL PRIMARY KEY,
    nama_provinsi VARCHAR(100) NOT NULL UNIQUE,
    kode_provinsi VARCHAR(10),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert 38 Provinsi Indonesia
INSERT INTO provinsi (nama_provinsi, kode_provinsi) VALUES
('Aceh', 'AC'),
('Sumatera Utara', 'SU'),
('Sumatera Barat', 'SB'),
('Riau', 'RI'),
('Jambi', 'JA'),
('Sumatera Selatan', 'SS'),
('Bengkulu', 'BE'),
('Lampung', 'LA'),
('Kepulauan Bangka Belitung', 'BB'),
('Kepulauan Riau', 'KR'),
('DKI Jakarta', 'JK'),
('Jawa Barat', 'JB'),
('Jawa Tengah', 'JT'),
('DI Yogyakarta', 'YO'),
('Jawa Timur', 'JI'),
('Banten', 'BT'),
('Bali', 'BA'),
('Nusa Tenggara Barat', 'NB'),
('Nusa Tenggara Timur', 'NT'),
('Kalimantan Barat', 'KB'),
('Kalimantan Tengah', 'KH'),
('Kalimantan Selatan', 'KS'),
('Kalimantan Timur', 'KT'),
('Kalimantan Utara', 'KU'),
('Sulawesi Utara', 'SN'),
('Sulawesi Tengah', 'SG'),
('Sulawesi Selatan', 'SL'),
('Sulawesi Tenggara', 'ST'),
('Gorontalo', 'GO'),
('Sulawesi Barat', 'SW'),
('Maluku', 'MA'),
('Maluku Utara', 'MU'),
('Papua Barat', 'PB'),
('Papua', 'PA'),
('Papua Selatan', 'PS'),
('Papua Tengah', 'PT'),
('Papua Pegunungan', 'PP'),
('Astra Daratan', 'AD')
ON CONFLICT (nama_provinsi) DO NOTHING;
