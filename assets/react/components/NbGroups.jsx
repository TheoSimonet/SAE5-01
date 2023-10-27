import React, { useState, useEffect } from 'react';
import "../../styles/semesterDetail.css"

function NbGroups({nbGroups}, {group}) {
    return (
        <div>
        {nbGroups === null
            ? 'Aucun Nombre De Groupe Trouvé'
            :  nbGroups
                .filter((nbGroup) => nbGroup.groups.includes(`/api/groups/${group.id}`))
                .map((filteredNbGroup) => (
                    filteredNbGroup.nbGroup === 0 || filteredNbGroup.nbGroup === null
                        ? null
                        : <span key={`${filteredNbGroup.id}`}> | {filteredNbGroup.nbGroup}</span>
                ))
        }
        </div>
    )
}

export default NbGroups;