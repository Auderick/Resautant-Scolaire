ALTER TABLE presences 
ADD COLUMN absent BOOLEAN DEFAULT false AFTER present;

-- Mettre à jour les enregistrements existants
-- Si present=true alors absent=false, sinon si present=false alors absent=true
UPDATE presences SET absent = NOT present;
