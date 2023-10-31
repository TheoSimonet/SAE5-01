import React, { useState, useEffect } from 'react';
import Modal from 'react-modal';
import { fetchWish, updateWish } from '../services/api';


Modal.setAppElement('#root');
function EditWishForm({ isOpen, onRequestClose, wishId }) {
    const [chosenGroups, setChosenGroups] = useState('');
    const [groupeType, setGroupeType] = useState('');

    useEffect(() => {
        if (isOpen) {

            fetchWish(wishId).then((data) => {
                setChosenGroups(data.chosenGroups);
                setGroupeType(data.groupeType.id);
            });
        }
    }, [isOpen, wishId]);

    const handleSubmit = (event) => {
        event.preventDefault();

        const formData = {
            chosenGroups,
            groupeType,
        };

        updateWish(wishId, formData)
            .then(() => {
                onRequestClose();
            })
            .catch((error) => {
                console.error('Error updating wish:', error);
            });
    };

    return (
        <Modal
            isOpen={isOpen}
            onRequestClose={onRequestClose}
            contentLabel="Modifier le voeu"
        >
            <h2>Modifier le voeu</h2>
            <form onSubmit={handleSubmit}>

                <button type="submit">Enregistrer</button>
            </form>
        </Modal>
    );
}
