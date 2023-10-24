import React, { useState, useEffect } from 'react';
import "../../styles/repartition.css";
import {Link, Route, Router} from 'wouter';
import {fetchWishes} from "../services/api";

function Repartition() {
    const [wishes, setWishes] = useState([]);

    useEffect(() => {
        fetchWishes()
            .then(data => {
                if (data) {
                    setWishes(data['hydra:member']);
                }
            })
            .catch(error => {
                console.error("Error fetching wishes:", error);
            });
    }, []);

    return (
        <div className="table-container">
            <h2>Répartition de vos heures</h2>
            <table>
                <thead>
                <tr>
                    <th>Cours</th>
                    <th>Groupe</th>
                    <th>Modification</th>
                </tr>
                </thead>
                <tbody>
                {wishes.map(wish => (
                    <tr key={wish.id}>
                        <td>{wish.subjectId}</td>
                        <td>{wish.chosenGroups}</td>
                        <td>
                            <button className="modifier-button">Modifier</button>
                            <button className="supprimer-button">Supprimer</button>
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
