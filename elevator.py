import time
import random
class elevators:
    def __init__(self,floor,name):
        self.floor=floor
        self.name=f'第{name+1}部電梯'
    def floor_distance(self,distance,real_distance): #distance是絕對值，單純計算我目前樓層跟電梯樓層的距離，而real_distance則沒有絕對值，因為要計算是上還是下
        self.distance=distance
        self.real_distance=real_distance
bottom=random.randint(-6,0)
top=random.randint(2,11)
building_floor=[str(i) for i in range(bottom,top)]
building_floor.remove('0')
for floor in range(len(building_floor)):
    if '-' in building_floor[floor]:
        building_floor[floor]=building_floor[floor].replace('-','B')
elevator=[elevators(random.choice(building_floor),i) for i in range(random.randint(1,3))]
print('目前這棟大樓存在',*building_floor)
now_floor=input('你目前的樓層: ')
if now_floor !=building_floor[0] and now_floor!= building_floor[-1]:
    up_or_down=input('你要上還是下: ')
elif now_floor ==building_floor[0]:
    up_or_down='上'
else:
    up_or_down='下'
floor_index=building_floor.index(now_floor) #目前樓層在大樓樓層中的索引直
for elevator_e in elevator:
    elevator_floor=building_floor.index(elevator_e.floor)
    elevator_e.floor_distance(abs(elevator_floor-floor_index),elevator_floor-floor_index)
elevator_distance=[i.distance for i in elevator]
#print(elevator_distance)
min_distance=len(building_floor)+1
wait=True
for floor in elevator:
    if floor.distance<min_distance:
        min_distance=floor.distance
        elevator_selected=floor
        if floor.distance==0:
            wait=False
            break
if wait:
    if elevator_selected.real_distance>0: #大於0代表電梯在目前樓層的上面
        for i in range(min_distance):
            time.sleep(1)
            elevator_selected.floor=building_floor[building_floor.index(elevator_selected.floor)-1]
            elevator_selected.distance-=1
            elevator_selected.real_distance-=1
            print(f'{elevator_selected.name} 到{elevator_selected.floor}')

    else:
        for i in range(min_distance):
            time.sleep(1)
            elevator_selected.floor=building_floor[building_floor.index(elevator_selected.floor)+1]
            elevator_selected.distance+=1
            elevator_selected.real_distance+=1
            print(f'{elevator_selected.name} 到{elevator_selected.floor}')
print('電梯門開了')
goal_floor=input('你要去哪一層樓: ')
goal_floor_index=building_floor.index(goal_floor)
if goal_floor_index>floor_index:
    for i in range(abs(goal_floor_index-floor_index)):
        time.sleep(1)
        elevator_selected.floor = building_floor[building_floor.index(elevator_selected.floor) + 1]
        print(f'{elevator_selected.name} 到{elevator_selected.floor}')
else:
    for i in range(abs(goal_floor_index-floor_index)):
        time.sleep(1)
        elevator_selected.floor=building_floor[building_floor.index(elevator_selected.floor)-1]
        print(f'{elevator_selected.name} 到{elevator_selected.floor}')
print(f'電梯門開了')
now_floor=goal_floor
floor_index=goal_floor_index
