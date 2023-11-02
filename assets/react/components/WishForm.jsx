import React, { useState } from 'react';
import { toast } from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';

function WishForm({ subjectId, onWishAdded, wishUser }) {
    const [chosenGroups, setChosenGroups] = useState('');
    const [groupeType, setGroupeType] = useState('');

    const handleSubmit = async (event) => {
        event.preventDefault();

        // Vérifier si les valeurs requises sont disponibles pour effectuer la requête
        if (!wishUser || !subjectId || !groupeType) {
            return;
        }

        const formData = {
            chosenGroups,
            subjectId,
            groupeType,
            wishUser: `/api/users/${wishUser.id}`,
        };

        try {
            const response = await fetch('/api/wishes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${wishUser.token}`,
                },
                body: JSON.stringify(formData),
            });

            if (response.ok) {
                toast.success('Vœu ajouté avec succès!', {
                    position: 'top-left',
                    autoClose: 2000,
                    closeOnClick: true,
                    theme: 'colored',
                });

                // Appeler la fonction de rappel lors de l'ajout réussi du vœu
                if (onWishAdded) {
                    onWishAdded();
                }
            } else {
                throw new Error('Erreur de requête');
            }
        } catch (error) {
            console.error('Une erreur s\'est produite :', error);
            toast.error('Erreur lors de l\'ajout du vœu', {
                position: 'top-right',
                autoClose: 2000,
                closeOnClick: true,
                theme: 'colored',
            });
        }
    };

    return (
        <form onSubmit={handleSubmit}>
            <div className="form-group">
                <label htmlFor="chosenGroups">Nombre de groupe</label>
                <input
                    type="number"
                    id="chosenGroups"
                    name="chosenGroups"
                    min="1"
                    value={chosenGroups}
                    onChange={(e) => setChosenGroups(parseInt(e.target.value, 10))}
                    className="form-control"
                />
            </div>

            <div className="form-group">
                <label htmlFor="groupeType">Type de groupe</label>
                <select
                    id="groupeType"
                    name="groupeType"
                    value={groupeType}
                    onChange={(e) => setGroupeType(e.target.value)}
                    className="form-control"
                >
                    <option value="">Sélectionnez un groupe</option>
                    {/* Option pour les types de groupes */}
                </select>
            </div>

            <button type="submit" className="btn btn-primary">
                Postuler
            </button>
        </form>
    );
}

export default WishForm;
