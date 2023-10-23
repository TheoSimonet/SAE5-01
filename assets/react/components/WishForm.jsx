import React, { useState, useEffect } from 'react';
import { getMe, fetchGroups } from '../services/api';
import { toast } from "react-toastify";
import 'react-toastify/dist/ReactToastify.css';

function WishForm({ subjectId }) {
    const [chosenGroups, setChosenGroups] = useState('');
    const [groupeType, setGroupeType] = useState('');
    const [groupeTypes, setGroupeTypes] = useState([]);
    const [groups, setGroups] = useState([]);
    const [wishUser, setWishUser] = useState(null); // Initialisez le wishUser à null

    useEffect(() => {
        // Utilisez l'effet pour obtenir l'utilisateur actuel
        getMe().then((userData) => {
            setWishUser(userData);
        });

        fetchGroups().then((data) => {
            setGroupeTypes(data);
        });

        fetchGroups().then((data) => {
            setGroups(data);
        });
    }, []);

    const handleSubmit = (event) => {
        event.preventDefault();
        const selectedGroup = groupeTypes.find((group) => group.id === groupeType);
        const groupId = selectedGroup ? selectedGroup.id : '';

        const formData = {
            chosenGroups,
            subjectId,
            groupeType,
            wishUser:`/api/users/${wishUser.id}`,
        };

        fetch('/api/wishes', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${wishUser.token}`
            },
            body: JSON.stringify(formData),
        })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Erreur de requête');
                }
            })
            .then(data => {
                toast.success('Vœu ajouté avec succès!', {
                    position: 'top-left',
                    autoClose: 2000,
                    closeOnClick: true,
                    theme: 'colored',
                });
            })
            .catch(error => {
                console.error('Une erreur s\'est produite :', error);
                toast.error('Erreur lors de l\'ajout du vœu', {
                    position: 'top-right',
                    autoClose: 2000,
                    closeOnClick: true,
                    theme: 'colored',
                });
            });
    };

    return (
        <form onSubmit={handleSubmit}>
            <div className="form-group">
                <label htmlFor="chosenGroups">Nombre de groupe</label>
                <input
                    type="number"
                    id="chosenGroups"
                    name="chosenGroups"
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
                    {groups.map((group) => (
                        <option key={group.id} value={`/api/groups/${group.id}`}>
                            {group.type}
                        </option>
                    ))}
                </select>
            </div>

            <button type="submit" className="btn btn-primary">Postuler</button>
        </form>
    );
}

export default WishForm;
