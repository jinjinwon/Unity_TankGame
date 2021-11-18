﻿using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class EffectPool : MonoBehaviour
{
    [HideInInspector] public static EffectPool Inst = null;
    Dictionary<string, List<EffectPoolUnit>> m_DicEffectPool = new Dictionary<string, List<EffectPoolUnit>>();

    int m_PreSetSize = 20;   // 몇개가 생길지는 모르지만 기본적으로 3개를 만들어 놓는다.

    void Awake()
    {
        Inst = this;

    }

    // Start is called before the first frame update
    void Start()
    {
        StartCreate("WFX_Explosion Small");
        StartCreate("LaserImpactPFX");
        StartCreate("FX_Fire_01");
        //공격 성공 시 Target위치에 이펙트
        StartCreate("Tower01_AttackSuccess_FX");
        StartCreate("SuperTower_AttackSucess_FX");
    }


    public void StartCreate(string effectName)
    {
        List<EffectPoolUnit> listObjectPool = null;
        if (m_DicEffectPool.ContainsKey(effectName) == true)
        {
            listObjectPool = m_DicEffectPool[effectName];
        }
        else //if (listObjectPool == null)
        {
            m_DicEffectPool.Add(effectName, new List<EffectPoolUnit>());
            listObjectPool = m_DicEffectPool[effectName];
        }

        GameObject prefab = Resources.Load<GameObject>("TowerEffect/" + effectName);

        if (prefab != null)
        {
            var results = prefab.GetComponentsInChildren<Transform>();
            for (int k = 0; k < results.Length; k++)
                results[k].gameObject.layer = LayerMask.NameToLayer("TransparentFX");

            for (int j = 0; j < m_PreSetSize; j++) //미리 3개 정도 만들어 둠
            {
                GameObject obj = Instantiate(prefab) as GameObject;

                EffectPoolUnit objectPoolUnit = obj.GetComponent<EffectPoolUnit>();
                if (objectPoolUnit == null)
                {
                    objectPoolUnit = obj.AddComponent<EffectPoolUnit>();
                }

                obj.transform.SetParent(transform);
                obj.GetComponent<EffectPoolUnit>().SetObjectPool(effectName, this);
                if (obj.activeSelf)
                {
                    obj.SetActive(false);
                }
                else
                {
                    AddPoolUnit(effectName, obj.GetComponent<EffectPoolUnit>());
                }
            }
        }
    }

    public GameObject GetEffectObj(string effectName, Vector3 position, Quaternion rotation)
    {
        List<EffectPoolUnit> listObjectPool = null;
        if (m_DicEffectPool.ContainsKey(effectName) == true)
        {
            listObjectPool = m_DicEffectPool[effectName];
        }
        else //if (listObjectPool == null)
        {
            m_DicEffectPool.Add(effectName, new List<EffectPoolUnit>());
            listObjectPool = m_DicEffectPool[effectName];
        }

        if (listObjectPool == null)
            return null;

        if (listObjectPool.Count > 0)
        {
            if (listObjectPool[0] != null && listObjectPool[0].IsReady())//0번도 준비가 안되면 나머지는 무조건 안되있기떄문에 0번검사
            {
                EffectPoolUnit unit = listObjectPool[0];
                listObjectPool.Remove(listObjectPool[0]);
                unit.transform.position = position;
                unit.transform.rotation = rotation;
                StartCoroutine(Coroutine_SetActive(unit.gameObject));
                return unit.gameObject;
            }
        }

        // 실행중이라면 새로 생성
        GameObject prefab = Resources.Load<GameObject>("TowerEffect/" + effectName);
        GameObject obj = Instantiate(prefab) as GameObject;

        EffectPoolUnit objectPoolUnit = obj.GetComponent<EffectPoolUnit>();
        if (objectPoolUnit == null)
        {
            objectPoolUnit = obj.AddComponent<EffectPoolUnit>(); //OnDisable()시 메모리풀로 돌리기... 1초딜레이 후 사용가능하도록
        }

        obj.GetComponent<EffectPoolUnit>().SetObjectPool(effectName, this);
        StartCoroutine(Coroutine_SetActive(obj));
        return obj;
    }

    IEnumerator Coroutine_SetActive(GameObject obj)
    {
        yield return new WaitForEndOfFrame();
        obj.SetActive(true);
    }

    public void AddPoolUnit(string effectName, EffectPoolUnit unit)
    {
        List<EffectPoolUnit> listObjectPool = m_DicEffectPool[effectName];
        if (listObjectPool != null)
        {
            listObjectPool.Add(unit);
        }
    }
}
