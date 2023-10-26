import React, { useState, useEffect } from 'react';
import "../../styles/repartition.css";
import { Link } from 'wouter';
import { fetchWishes, getMe, getSubject, getSubjectGroup, deleteWish } from "../services/api";
import EditWishForm from './EditWishForm';

function Repartition() {
    const [wishes, setWishes] = useState([]);
    const [userId, setUserId] = useState(null);

    const [isEditModalOpen, setIsEditModalOpen] = useState(false);
    const [editWishId, setEditWishId] = useState(null);

    const handleEditWish = (wishId) => {
        setIsEditModalOpen(true);
        setEditWishId(wishId);
    };
    const closeEditModal = () => {
        setIsEditModalOpen(false);
        setEditWishId(null);
    };

    useEffect(() => {
        const fetchData = async () => {
            try {
                const userData = await getMe();
                if (userData) {
                    const currentUserID = userData.id;
                    setUserId(currentUserID);
                    const wishData = await fetchWishes();
                    if (wishData && Array.isArray(wishData['hydra:member'])) {
                        const userWishes = wishData['hydra:member'].filter(wish => {
                            return wish.wishUser === `/api/users/${currentUserID}`;
                        });

                        const wishesWithSubjects = await Promise.all(userWishes.map(async wish => {
                            const subjectResponse = await getSubject(wish.subjectId);
                            const subjectGroupResponse = await getSubjectGroup(wish.groupeType);

                            if (subjectResponse) {
                                wish.subjectName = subjectResponse.name;
                                wish.subjectCode = subjectResponse.subjectCode
                                wish.groupName = subjectGroupResponse.type;
                            }
                            return wish;
                        }));

                        setWishes(wishesWithSubjects);
                    }
                }
            } catch (error) {
                console.error("Error fetching data:", error);
            }
        };
        fetchData();
    }, []);

    const handleDeleteWish = async (wishId) => {
        const confirmed = window.confirm("Voulez-vous vraiment supprimer ce vœu ?");
        if (confirmed) {
            try {
                await deleteWish(wishId);
                setWishes(wishes.filter(wish => wish.id !== wishId));
            } catch (error) {
                console.error("Error deleting wish:", error);
            }
        }
    };


    return (
        <div className="table-container">
            <h2 className={"repartition"}>Répartition de vos heures</h2>
            <table>
                <thead>
                <tr>
                    <th>Cours</th>
                    <th>Groupes</th>
                    <th>Modification</th>
                </tr>
                </thead>
                <tbody>
                {wishes.map(wish => (
                    <tr key={wish.id}>
                        <td>{wish.subjectCode + ' - ' + wish.subjectName}</td>
                        <td>{wish.chosenGroups} groupes de {wish.groupName} </td>
                        <td>
                            <button className="modifier-button" onClick={() => handleEditWish(wish.id)}>Modifier</button>
                            <button className="supprimer-button" onClick={() => handleDeleteWish(wish.id)}>Supprimer</button>
                        </td>
                    </tr>
                ))}
                <tr>
                    <td>
                        <Link to="/react/semesters" className="ajouter-button">Ajouter des heures</Link>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    );
}

export default Repartition;
