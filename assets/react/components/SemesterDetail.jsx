import React, {useState, useEffect} from 'react';
import {getSemester} from '../services/api';
import {useRoute} from 'wouter';
import Modal from 'react-modal';

function Semester() {
    const [semester, setSemester] = useState(null);
    const [, params] = useRoute('/react/semesters/:id');
    const [modalIsOpen, setIsOpen] = React.useState(false);
    const customStyles = {
        content: {
            fontSize: '3em',
            top: '50%',
            left: '50%',
            width: '50%',
            right: 'auto',
            bottom: 'auto',
            marginRight: '-50%',
            transform: 'translate(-50%, -50%)',
        },
        overlay: {
            backgroundColor: 'rgba(0, 0, 0, 0.2)',
            zIndex: 1000,
        },
    };

    useEffect(() => {
        getSemester(params.id).then((data) => {
            setSemester(data);


        });
    }, [params.id]);

    function openModal() {
        setIsOpen(true);
    }

    function closeModal() {
        setIsOpen(false);
    }

    return (
        <div>
            {semester === null ? 'Loading...' : (
                <div>
                    <ul>
                        {semester.subject.map((subject) => (
                            <li key={subject['@id']} className="semester-li">
                                {subject.subjectCode + ' - ' + subject.name}
                                <br/><br/>
                                <p className="groupe">Groupes |</p>
                                <div className="Postuler-container">
                                    <button className="Postuler" onClick={openModal}>Postuler</button>
                                    <Modal
                                        isOpen={modalIsOpen}
                                        onRequestClose={closeModal}
                                        style={customStyles}
                                    >   <div className="modal">
                                        <h2 className='modalTitle'>Réserver un cours</h2>
                                        <form>
                                            <p>Nombre de groupe(s) :</p>
                                            <input type="number" id="entierPositif" name="entierPositif" min="0" step="1" placeholder="0" /><br/>
                                            <select id="typeCours" name="typeCours">
                                                <option value="TD">TD (Travaux Dirigés)</option>
                                                <option value="TP">TP (Travaux Pratiques)</option>
                                                <option value="CM">CM (Cours Magistraux)</option>
                                            </select>
                                        </form>
                                        <button onClick={closeModal}>Fermer</button>
                                        <button onClick={closeModal}>Valider</button>
                                        </div>
                                    </Modal>
                                </div>

                            </li>
                        ))}
                    </ul>
                </div>
            )}
        </div>
    );
}

export default Semester;
