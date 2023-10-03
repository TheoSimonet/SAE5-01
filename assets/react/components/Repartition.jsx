import React, { useState, useEffect } from 'react';
import "../../styles/repartition.css";
import {Link, Route, Router} from 'wouter';

function Repartition() {
    return (
        <div className="table-container">
            <h2>Répartition de vos heures</h2>
            <table>
                <thead>
                <tr>
                    <th>Cours</th>
                    <th>Section</th>
                    <th>Volume</th>
                    <th>Modification</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Cours 1</td>
                    <td>Section A</td>
                    <td>30 heures</td>
                    <td>
                        <button className="modifier-button">Modifier</button>
                        <button className="supprimer-button">Supprimer</button>
                    </td>
                </tr>
                <tr>
                    <td>Cours 2</td>
                    <td>Section B</td>
                    <td>20 heures</td>
                    <td>
                        <button className="modifier-button">Modifier</button>
                        <button className="supprimer-button">Supprimer</button>
                    </td>
                </tr>

                <tr>
                    <td colSpan="3"></td>
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
