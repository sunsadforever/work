import random
import time
building=[str(floor) for floor in range(random.randint(-6,-1),random.randint(7,15))]#有幾層樓
building.remove('0')
#print(building)
for i in range(len(building)):
    if '-' in building[i]:
        building[i]=building[i].replace('-','B')
print(*building)
class elevator():
    def __init__(self,floor,name):
        self.floor=floor
        self.name=f'第{name}部電梯'
elevator_list=[elevator(random.choice(building),i) for i in range(1,random.randint(1,3)+1)] #有幾個電梯
print(f'你所在的大樓有{len(building)}層')
print(f'本大樓有{len(elevator_list)}部電梯')
now_location=0
while True:
    now_location=input('你在哪一層樓:')
    if now_location in building:
        break
if now_location ==building[len(building)-1]:
    button=['向下']
elif now_location==building[0]:
    button=['向上']
else:
    button=['向上','向下']

next_floor=''
while True:
    answer=input('你要向下還是向上: ')
    if answer in button:
        next_floor=input('你要去哪個樓層: ')
        if next_floor in building:
            if answer =='向上' and building.index(next_floor)>building.index(now_location):
                break
            elif answer =='向下' and building.index(next_floor)<building.index(now_location):
                break
distance=[] #要比較每個電梯的距離
'''for num in elevator_list:
    print(num.name,':',num.floor)'''
for num in range(len(elevator_list)):
    distance.append(building.index(elevator_list[num].floor)-building.index(now_location))
    #print(building.index(elevator_list[num].floor) - building.index(now_location))
#print(distance)
closest = min(distance, key=abs) #最小距離
elevator_execute=0 #被選中的電梯的索引
elevator_selected='' #被選中的電梯
for num in range(len(distance)):
    if abs(distance[num])==abs(closest):
        elevator_execute=building.index(elevator_list[num].floor)
        elevator_selected=elevator_list[num].name
        #print('this: ',elevator_execute,'and',building.index(now_location),'distance',elevator_execute-building.index(now_location))
        if distance[num]>0:                                             #如果電梯在我目前的樓層之上，distance[num]=building.index(elevator_list[num].floor)-building.index(now_location)
            for up in range(abs(elevator_execute-building.index(now_location))):
                elevator_execute -=1
                elevator_list[num].floor=building[elevator_execute]
                time.sleep(3)
                print(f'{elevator_selected}目前在{elevator_list[num].floor}')
        else:                                                           #如果電梯在我目前的樓層之下
            for down in range(abs(elevator_execute-building.index(now_location))):
                elevator_execute += 1
                elevator_list[num].floor=building[elevator_execute]
                time.sleep(3)
                print(f'{elevator_selected}目前在{elevator_list[num].floor}')
        print(f'{elevator_selected}打開')
        time.sleep(1)
        print(f'{elevator_selected}已關')
        if building.index(next_floor)-building.index(now_location) < 0: #如果目的地樓層在目前樓層之下
            for up in range(abs(building.index(now_location)-building.index(next_floor)) ):
                elevator_execute -=1
                elevator_list[num].floor = building[elevator_execute]
                time.sleep(3)
                print(f'{elevator_selected}目前在{elevator_list[num].floor}')
        else:                                                           #如果目的地樓層在目前樓層之上
            for down in range(abs(building.index(now_location)-building.index(next_floor)) ):
                elevator_execute+=1
                elevator_list[num].floor = building[elevator_execute]
                time.sleep(3)
                print(f'{elevator_selected}目前在{elevator_list[num].floor}')
        print(f'{elevator_selected}打開')
        now_location=next_floor
        break
