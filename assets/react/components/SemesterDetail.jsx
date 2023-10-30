import React, { useState, useEffect } from 'react';
import {
    getSemester,
    fetchNbGroup,
    fetchGroups,
    getMe,
} from '../services/api';
import { useRoute } from 'wouter';
import WishForm from './WishForm';
import "../../styles/semesterDetail.css"

function Semester() {
    const [semester, setSemester] = useState(null);
    const [, params] = useRoute('/react/semesters/:id');
    const [userData, setUserData] = useState(null);
    const [groups, setGroups] = useState([]);
    const [nbGroups, setNbGroups] = useState([]);
    const [wishesBySubject, setWishesBySubject] = useState({});

    useEffect(() => {
        (async () => {
            setGroups(await fetchGroups())

            const groupData = await fetchNbGroup();
            if (Array.isArray(groupData['hydra:member'])) {
                setNbGroups(groupData['hydra:member']);
            } else if (Array.isArray(groupData.nbGroups)) {
                setNbGroups(groupData.nbGroups);
            } else {
                console.error("Data from API is not an array:", groupData);
            }
        })()
    }, []);

    useEffect(() => {
        getSemester(params.id).then((data) => {
            setSemester(data);
        });
        getMe().then((userData) => {
            setUserData(userData);
        });
    }, [params.id]);

    const getWishesCountBySubject = async () => {
        try {
            const allWishesResponse = await fetch('/api/wishes');
            if (!allWishesResponse.ok) {
                throw new Error('La requête pour les souhaits a échoué.');
            }

            const allWishes = await allWishesResponse.json();
            console.log('All Wishes:', allWishes);

            const wishesBySubjectData = {};

            if (Array.isArray(allWishes['hydra:member'])) {
                for (const wish of allWishes['hydra:member']) {
                    const groupeType = wish.groupeType;
                    const chosenGroups = wish.chosenGroups || 0;

                    if (!wishesBySubjectData[groupeType]) {
                        wishesBySubjectData[groupeType] = chosenGroups;
                    } else {
                        wishesBySubjectData[groupeType] += chosenGroups;
                    }
                }

                console.log('Wishes Count by Group:', wishesBySubjectData);
                setWishesBySubject(wishesBySubjectData); // Mise à jour de l'état avec les valeurs cumulées
            } else {
                console.error("hydra:member n'est pas un tableau :", allWishes['hydra:member']);
            }
        } catch (error) {
            console.error("Une erreur s'est produite lors du traitement des souhaits :", error);
        }
    };

    useEffect(() => {
        if (semester !== null) {
            getWishesCountBySubject()
                .then(() => {
                })
                .catch(error => {
                    console.error("Une erreur s'est produite :", error);
                });
        }
    }, [semester]);

    return (
        <div>
            {semester === null ? 'Loading...' : (
                <div className={"subjectList"}>
                    <ul>
                        {semester.subjects.map((subject) => {
                            const subjectId = subject['@id'].split('/').pop();
                            return (
                                <li key={subject['@id']} className="semester-li">
                                    <h2 className={"subjectName"}>{subject.subjectCode + ' - ' + subject.name}</h2>
                                    <br /><br />
                                    {(userData && userData.roles && userData.roles.includes("ROLE_ADMIN")) ? (
                                        <div>
                                            <div className="groupe-container">
                                                {groups === null ? 'Aucun Groupe Trouvé' : (
                                                    groups.filter((group) => group.subject === subject['@id'])
                                                        .map((group) => (
                                                            <ul key={group.id}>
                                                                <li className="groups">
                                                                    {group.type}
                                                                    {nbGroups === null ? (
                                                                        'Aucun Nombre De Groupe Trouvé'
                                                                    ) : (
                                                                        nbGroups
                                                                            .filter((nbGroup) => nbGroup.groups.includes(`/api/groups/${group.id}`))
                                                                            .map((filteredNbGroup) => {
                                                                                if (filteredNbGroup.nbGroup === 0 || filteredNbGroup.nbGroup === null) {
                                                                                    return null;
                                                                                } else {
                                                                                    const groupId = (typeof filteredNbGroup.groups === 'string') ? filteredNbGroup.groups.split('/').pop() : filteredNbGroup.groups;
                                                                                    const subjectWishes = wishesBySubject[subject['@id']];
                                                                                    const wishesCount = (subjectWishes && subjectWishes[groupId]) ? subjectWishes[groupId] : 0;
                                                                                    return (
                                                                                        <span key={`${filteredNbGroup.id}`}>| {JSON.stringify(wishesBySubject, null, 2)} / {filteredNbGroup.nbGroup} </span>
                                                                                    );
                                                                                }
                                                                            })
                                                                    )}
                                                                </li>
                                                            </ul>
                                                        ))
                                                )}
                                            </div>
                                            <div className="Postuler-container">
                                                <WishForm subjectId={`/api/subjects/${subjectId}`} />
                                            </div>
                                        </div>
                                    ) : null}
                                </li>
                            );
                        })}
                    </ul>
                </div>
            )}
        </div>
    );
}

export default Semester;

