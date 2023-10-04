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
            top: '50%',
            left: '50%',
            right: 'auto',
            bottom: 'auto',
            marginRight: '-50%',
            transform: 'translate(-50%, -50%)',
        },
        overlay: {
            backgroundColor: 'rgba(0, 0, 0, 0.2)', // Fond semi-transparent
            zIndex: 1000, // Assure que le modal est au-dessus du reste du contenu
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
                                    >
                                        <h2>Hello</h2>
                                        <button onClick={closeModal}>close</button>
                                        <div>I am a modal</div>
                                        <form>
                                            <input />
                                        </form>
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
