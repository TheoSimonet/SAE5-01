import React, { useState, useEffect } from 'react';
import { postWish } from '../services/api';
import { fetchGroupTypes } from '../services/api';

function WishForm({ subjectId }) {
    const [chosenGroups, setChosenGroups] = useState('');
    const [groupeType, setGroupeType] = useState('');
    const [loading, setLoading] = useState(false);
    const [groupTypes, setGroupTypes] = useState([]);

    useEffect(() => {
        fetchGroupTypes()
            .then((data) => {
                if (Array.isArray(data)) {
                    setGroupTypes(data);
                } else {
                    console.error('Les types de groupe ne sont pas au format attendu');
                }
            })
            .catch((error) => {
                console.error('Erreur lors de la récupération des types de groupe', error);
            });
    }, []);

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);

        try {
            // Récupérer l'ID correspondant à l'index de l'option sélectionnée
            const selectedTypeIndex = groupTypes.findIndex((type) => type === groupeType);

            if (selectedTypeIndex !== -1) {
                // Si l'index est trouvé, utilisez-le comme ID
                const selectedTypeId = `/api/groups/${selectedTypeIndex + 1}`; // Ajoutez "/api/groups/" + ID
                await postWish({ chosenGroups, groupeType: selectedTypeId });
            } else {
                console.error('Type de groupe non trouvé :', groupeType);
            }

            setChosenGroups('');
            setGroupeType('');
        } catch (error) {
            console.error('Erreur lors de la soumission du voeu', error);
        }

        setLoading(false);
    };

    return (
        <form onSubmit={handleSubmit}>
            <input
                type="text"
                placeholder="Nombre de groupe(s)"
                value={chosenGroups}
                onChange={(e) => setChosenGroups(e.target.value)}
            />
            <select
                value={groupeType}
                onChange={(e) => setGroupeType(e.target.value)}
            >
                {groupTypes.map((type) => (
                    <option key={type} value={type}>
                        {type}
                    </option>
                ))}
            </select>

            <button type="submit" disabled={loading}>
                {loading ? 'Envoi en cours...' : 'Créer un voeu'}
            </button>
        </form>
    );
}

export default WishForm;
